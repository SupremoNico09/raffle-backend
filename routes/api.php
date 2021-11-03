<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PrizeController;
use App\Http\Controllers\API\RaffleController;
use App\Http\Controllers\API\FrontendController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('getPrize', [FrontendController::class, 'prize']);

Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function () {

    Route::get('/checkingAuthenticated' , function () {
        return response()->json(['message'=>'You are in', 'status'=>200], 200);
    });

    //Prizes
    Route::get('view-prize', [PrizeController::class, 'index']);
    Route::post('store-prize', [PrizeController::class, 'store']);
    Route::get('edit-prize/{id}', [PrizeController::class, 'edit']);
    Route::put('update-prize/{id}', [PrizeController::class, 'update']);
    Route::delete('delete-prize/{id}', [PrizeController::class, 'destroy']);
    Route::get('all-prize', [PrizeController::class, 'allprize']);

    //Raffles
    Route::post('store-raffle', [RaffleController::class, 'store']);
    Route::get('view-raffle', [RaffleController::class, 'index']);
    Route::get('edit-raffle/{id}', [RaffleController::class, 'edit']);
    Route::post('update-raffle/{id}', [RaffleController::class, 'update']);
    Route::delete('delete-raffle/{id}', [RaffleController::class, 'destroy']);


});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
