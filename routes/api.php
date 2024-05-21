<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'users',
    //'middleware' => ['auth', 'sanctum']
], function() {

    $controller = \App\Http\Controllers\ApiUserController::class;

    Route::get('/', [$controller, 'index']);

    Route::get('/{user}', [$controller, 'show']);

    Route::post('/', [$controller, 'create']);

    Route::put('/{id}', [$controller, 'update']);


    Route::delete('/{id}', [$controller, 'destroy']);

    Route::patch('/{id}/set-status', [$controller, 'setStatus']);

    
});

Route::group([
    'prefix' => 'products',
    //'middleware' => ['auth', 'sanctum']
], function() {

    $controller = \App\Http\Controllers\ApiController::class;

    Route::get('/', [$controller, 'index']);

    Route::get('/{id}', [$controller, 'show']);

    Route::post('/', [$controller, 'create']);

    Route::put('/{id}', [$controller, 'update']);
}
);