<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\Ticket;
use App\Models\tickets;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{

    public function tickets()
    {
        $tickets = Ticket::all();
        return response()->json([
            'status' => 200,
            'tickets' => $tickets
        ]);
    }


    public function deleteParticipant($id)
    {
        $tickets = Ticket::find($id);
        if ($tickets) {
            $tickets->delete();
            return response()->json([
                'status' => 200,
                'message' => 'User Deleted Successfully',

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Participant Id Found',
            ]);
        }
    }

    public function fetchParticipants($prize_name)
    {
        $raffles = Raffle::where('prize_name', $prize_name)->where('availability', 'Yes')->first();
        if ($raffles) {
            $tickets = Ticket::where('raffle_id', $raffles->id)->get();
            if ($tickets) {
                return response()->json([
                    'status' => 200,
                    'tickets_data' => [
                        'tickets' => $tickets,
                        'raffles' => $raffles,
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
}
