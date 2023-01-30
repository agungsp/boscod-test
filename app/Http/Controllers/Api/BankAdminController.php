<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateBankAdminRequest;
use App\Http\Requests\Api\UpdateBankAdminRequest;
use App\Http\Resources\ApiResource;
use App\Models\BankAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAdmin = BankAdmin::cursorPaginate(10)->toArray();
        return new ApiResource($bankAdmin, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBankAdminRequest $request)
    {
        $bankAdmin = BankAdmin::create(
            $request->validated()
        );

        if (!$bankAdmin) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            new ApiResource(resource: $bankAdmin, message: "Data has been created!")
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param integer $bankAdminId
     * @return \Illuminate\Http\Response
     */
    public function show(BankAdmin $bankAdmin)
    {
        return new ApiResource($bankAdmin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param integer $bankAdminId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAdminRequest $request, BankAdmin $bankAdmin)
    {
        $bankAdminId = $bankAdmin->id;
        $bankAdmin = $bankAdmin->update(
            $request->validated()
        );

        if (!$bankAdmin) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $bankAdmin = BankAdmin::find($bankAdminId);

        return response(
            new ApiResource(resource: $bankAdmin, message: "Data has been updated!")
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAdmin $bankAdmin)
    {
        $bankAdmin = $bankAdmin->delete();

        if (!$bankAdmin) {
            return response(
                new ApiResource(resource: [], success: false, message: "Something went wrong!"),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response(
            new ApiResource(resource: [], message: "Data has been deleted!")
        );
    }
}
