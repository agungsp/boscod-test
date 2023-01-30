<?php

use App\Http\Controllers\Api\BankAdminController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransferMappingController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => App\Http\Controllers\Api\AuthController::class,
    'prefix' => 'auth'
], function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('refresh', 'refresh');
    Route::post('logout', 'logout')->middleware(['auth:api']);
});

Route::resource('banks', BankController::class)->middleware(['auth:api'])->only(['index', 'show']);
Route::resource('admin_banks', BankAdminController::class)->middleware(['auth:api']);
Route::resource('transfer_mapping', TransferMappingController::class)->middleware(['auth:api']);

Route::group([
    'middleware' => ['auth:api', 'ilegalUser'],
    'prefix' => '{user}',
    'as' => 'users.'
], function () {

    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('transactions', TransactionController::class)->except(['delete']);

});

