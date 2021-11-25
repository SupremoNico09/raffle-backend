<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\PrizeController;
use App\Http\Controllers\API\RaffleController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\ListController;
use App\Http\Controllers\API\ParticipantController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('getPrizes',[FrontendController::class, 'prizes']);
Route::get('fetchraffles/{type}',[FrontendController::class, 'raffles']);
Route::get('view-raffle/{prizes_type}/{raffles_prize_name}',[FrontendController::class, 'viewraffle']); 





Route::post('add-to-list', [ListController::class, 'addtolist']);
Route::post('rafflelists', [ListController::class, 'viewlist']);
Route::put('list-updatequantity/{rafflelists_id}/{scope}',[ListController::class, 'updatequantity']);
Route::delete('delete-rafflelistitem/{rafflelists_id}',[ListController::class, 'deleteListitem']);

Route::post('validate-ticket', [CheckoutController::class, 'validateTicket']);
Route::post('place-ticket', [CheckoutController::class, 'placeticket']);


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


    //Participants
    Route::get('view-participants', [ParticipantController::class, 'tickets']);
    Route::delete('delete-participant/{id}', [ParticipantController::class, 'deleteParticipant']);
    Route::get('fetchparticipants/{prize_name}', [ParticipantController::class, 'fetchParticipants']);







});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
