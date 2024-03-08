<?php

    use Illuminate\Support\Facades\Route;


    Route::prefix('.well-known')->group(function () {
        Route::get('webfinger', \Bearlovescode\RecognizableService\Http\Controllers\WebfingerController::class);
    });