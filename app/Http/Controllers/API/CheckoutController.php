<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RaffleList;
use App\Models\Ticket;
use App\Models\Ticketitems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeticket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|max:191',
            'phone' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {

            $ticket = new Ticket;
            $ticket->raffle_id = $request->raffle_id;
            $ticket->firstname = $request->firstname;
            $ticket->lastname = $request->lastname;
            $ticket->email = $request->email;
            $ticket->phone = $request->phone;


            $ticket->payment_mode = $request->payment_mode;
            $ticket->tracking_no = 'tombola' . rand(1111, 9999);
            $ticket->save();

            // $rafflelists = RaffleList::where('user_id', $user_id)->get();

            // $ticketitems = [];
            // foreach ($rafflelists as $item) {
            //     $ticketitems[] = [
            //         'raffle_id' => $item->raffle_id,
            //         'qty' => $item->ticket_qty,
            //         'price' => $item->raffle->ticket,
            //     ];

            //     $item->raffle->update([
            //         'participant' => $item->raffle->participant + $item->ticket_qty
            //     ]);
            // }
            // $ticket->ticketitems()->createMany($ticketitems);
            // RaffleList::destroy($rafflelists);

            return response()->json([
                'status' => 200,
                'message' => 'Ticket Placed Successfully',
            ]);
        }
    }

    public function validateTicket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|max:191',
            'phone' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Form Validated Successfully',
            ]);
        }
    }
}
