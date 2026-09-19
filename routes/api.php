<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/whatsapp/webhook/{secret}',[\App\Http\Controllers\V1\Api\MessengerController::class,'webhook'])
        ->middleware('throttle:60,1')
        ->name('whatsapp.webhook');
});
