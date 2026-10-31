<?php
use App\Http\Controllers\Api\v1\TreeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/trees', [TreeController::class, 'index']);
    Route::post('/trees', [TreeController::class, 'store']);
    Route::get('/trees/{tree}', [TreeController::class, 'show']);
    Route::post('/trees/{tree}/care', [TreeController::class, 'care']);
});