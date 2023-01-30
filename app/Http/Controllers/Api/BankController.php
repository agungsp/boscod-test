<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = Bank::cursorPaginate(10)->toArray();
        return new ApiResource($bank, true);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param integer $bankId
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return new ApiResource($bank);
    }
}
