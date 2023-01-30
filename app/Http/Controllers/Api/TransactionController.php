<?php

namespace App\Http\Controllers\Api;

use App\Events\PaymentReceivedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateTransactionRequest;
use App\Http\Requests\Api\UpdateTransactionRequest;
use App\Http\Resources\ApiResource;
use App\Jobs\ForwardPaymentJob;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailState;
use App\Models\UniqueCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $transactions = Transaction::thisAuth()->cursorPaginate(10)->toArray();
        return new ApiResource($transactions, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request, User $user)
    {
        $transaction = null;
        $transactionDetail = null;
        DB::transaction(function () use (&$transaction, &$transactionDetail, $request, $user) {
            do {
                $generateCode = fake()->numerify("###");
                $uniqueCodeCheck = UniqueCode::where('code', $generateCode)->where('is_active', true)->count();
            } while ($uniqueCodeCheck > 0);

            $uniqueCode = UniqueCode::create([
                'code' => $generateCode,
                'is_active' => true
            ]);

            $req_transaction = collect($request->validated())
                            ->merge(['user_id' => $user->id, 'unique_code' => $uniqueCode->code])
                            ->except(['detail'])
                            ->toArray();
            $req_transaction = [
                ...$req_transaction,
                'transaction_code' => 'TR/' . date('YmdHis') . '/' . strtoupper(fake()->numerify("####"))
            ];
            $transaction = Transaction::create($req_transaction);

            $req_detail = array_map(function ($row) use ($transaction) {
                $row['transaction_id'] = $transaction->id;
                $row['transaction_detail_code'] = 'TRD/' . date('YmdHis') . '/' . strtoupper(fake()->numerify("####"));
                return $row;
            }, $request->validated()['detail']);

            $transaction_detail = TransactionDetail::insert($req_detail);
            $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->pluck('id');

            $states = array_map(function ($id) {
                return [
                    'transaction_detail_id' => $id,
                    'state_code' => TransactionDetail::STATE_PENDING,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $transaction_detail->toArray());

            TransactionDetailState::insert($states);
        });

        if (!$transaction) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $transaction->refresh();

        return response(
            new ApiResource(resource: $transaction, message: "Data has been created!")
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, int $transaction_id)
    {
        $transaction = Transaction::thisAuth()->find($transaction_id);
        return new ApiResource($transaction);
    }

    public function update(UpdateTransactionRequest $request, User $user, int $transaction_id)
    {
        $transaction = Transaction::thisAuth()->find($transaction_id);

        DB::transaction(function () use ($request, $transaction) {
            foreach ($transaction->details as $detail) {
                TransactionDetailState::create([
                    'transaction_detail_id' => $detail->id,
                    'state_code' => $request->state
                ]);
            }
        });

        $transaction->refresh();
        $transaction_detail = $transaction->details;

        // Inside of ForwardPaymentJob is unfinished
        ForwardPaymentJob::dispatchIf(
            $request->state == TransactionDetail::STATE_PROCESSING,
            $transaction_detail
        );

        $transaction = Transaction::thisAuth()->find($transaction_id);
        return new ApiResource($transaction);
    }
}
