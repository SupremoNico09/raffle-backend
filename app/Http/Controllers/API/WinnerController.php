<?php

namespace App\Http\Controllers\API;


use App\Events\WinnerChosen;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Winners;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function postwinner(Request $request){

        $tracking_no= $request->tracking_no;

        $winner = new Winners();
        $winner->raffle_id = $request->raffle_id;
        $winner->tracking_no = $request->tracking_no;
        $winner->save();


        event(new WinnerChosen($winner));

        $tickets = Ticket::where('tracking_no', $tracking_no)->get();
        Ticket::destroy($tickets);

        
        return response()->json([
            'status' => 200,
            'message' => 'Winner Placed Successfully',
        ]);
    }

    
    
}
