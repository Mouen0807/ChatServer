<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::group([

        'middleware' => 'api'

    ], function ($router) {

        Route::post('/new', [MessageController::class, 'store']);
        Route::get('/getOne/{id}', [MessageController::class, 'show']);
        Route::get('/getAll', [MessageController::class, 'getAll']);
        Route::put('/update/{id}', [MessageController::class, 'update']);
        Route::delete('/delete/{id}', [MessageController::class, 'destroy']);

    }
);

