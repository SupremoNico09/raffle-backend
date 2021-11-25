<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\Prize;
use App\Models\Ticket;
use App\Models\Ticketitems;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function prizes()
    {
        $prizes = Prize::where('availability', 'Yes')->get();
        return response()->json([
            'status' => 200,
            'prizes' => $prizes,
        ]);
    }

    public function raffles($type)
    {
        $prizes = Prize::where('type', $type)->where('availability', 'Yes')->first();
        if ($prizes) {
            $raffles = Raffle::where('prize_id', $prizes->id)->get();
            if ($raffles) {
                return response()->json([
                    'status' => 200,
                    'raffle_data' => [
                        'raffles' => $raffles,
                        'prizes' => $prizes,
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Raffle Available'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Prizes Found'
            ]);
        }
    }

    public function viewraffle($prizes_type, $raffles_prize_name)
    {
        $prizes = Prize::where('type', $prizes_type)->where('availability', 'Yes')->first();
        if ($prizes) {
            $raffles = Raffle::where('prize_id', $prizes->id)->where('prize_name', $raffles_prize_name)->first();
            if ($raffles) {
                return response()->json([
                    'status' => 200,
                    'raffles' => $raffles,
                    
                ]);
            } 
            else 
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Raffle Available'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Prizes Found'
            ]);
        }
    }

}
