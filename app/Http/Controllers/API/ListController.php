<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\RaffleList;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function addtolist(Request $request)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $raffle_id = $request->raffle_id;
            $ticket_qty = $request->ticket_qty;

            $raffleCheck = Raffle::where('id', $raffle_id)->first();
            if ($raffleCheck) {
                if (RaffleList::where('raffle_id', $raffle_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        'message' => $raffleCheck->name . 'Already Added to Your Raffle Lists',
                    ]);
                } else {
                    $rafflelistsitem = new RaffleList;
                    $rafflelistsitem->user_id = $user_id;
                    $rafflelistsitem->raffle_id = $raffle_id;
                    $rafflelistsitem->ticket_qty = $ticket_qty;
                    $rafflelistsitem->save();

                    return response()->json([
                        'status' => 201,
                        'message' => 'Added Raffle Lists'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Raffle Not Found'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to Add Raffle Lists'
            ]);
        }
    }

    public function viewlist()
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $rafflelistsitems = RaffleList::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                'rafflelists' => $rafflelistsitems,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to View Raffle Lists'
            ]);
        }
    }

    public function updatequantity($rafflelists_id, $scope)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $rafflelistsitem = RaffleList::where('id', $rafflelists_id)->where('user_id', $user_id)->first();
            if ($scope == "inc") {
                $rafflelistsitem->ticket_qty += 1;
            } else if ($scope == "dec") {
                $rafflelistsitem->ticket_qty -= 1;
            }
            $rafflelistsitem->update();
            return response()->json([
                'status' => 200,
                'message' => 'Quantity Updated'
            ]);

        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue'
            ]);
        }
    }

    public function deleteListitem($rafflelists_id)
    {
        if(auth('sanctum')->check())
        {
            $user_id = auth('sanctum')->user()->id;
            $rafflelistsitem = RaffleList::where('id', $rafflelists_id)->where('user_id', $user_id)->first();
            if($rafflelistsitem)
            {
                $rafflelistsitem->delete();
                return response()->json([
                    'status'=>200,
                    'messsage'=>'Removed Successfully',
                ]);
            } 
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Item not Found'
                ]); 
            }
        }
        else
        {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue'
            ]); 
        }
    }
}
