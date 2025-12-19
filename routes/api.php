<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;


Route::prefix('v1')->group(function () {
   Route::apiResource('customers', CustomerController::class);
   Route::post('customers/{customer}/deactivate', [CustomerController::class, 'deactivate']);
   Route::post('customers/{customer}/reactivate', [CustomerController::class, 'reactivate']);
});
