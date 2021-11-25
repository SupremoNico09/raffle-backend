<?php

namespace App\Http\Controllers\API;

use App\Models\Raffle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Symfony\Contracts\Service\Attribute\Required;

class RaffleController extends Controller
{

    public function index()
    {
        $raffles = Raffle::all();
        return response()->json([
            'status' => 200,
            'raffles' => $raffles
        ]);
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prize_id' => 'required|max:191',
            'prize_name' => 'required|max:191',
            'ticket' => 'required|max:191',
            'participant' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $raffle = new Raffle;
            $raffle->prize_id = $request->input('prize_id');
            $raffle->prize_name = $request->input('prize_name');
            $raffle->ticket = $request->input('ticket');
            $raffle->participant = $request->input('participant');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/raffle/', $filename);
                $raffle->image = 'uploads/raffle/' . $filename;
            }

            $raffle->description = $request->input('description');
            $raffle->save();

            return response()->json([
                'status' => 200,
                'message' => 'Raffle Created Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $raffle = Raffle::find($id);
        if ($raffle) {
            return response()->json([
                'status' => 200,
                'raffle' => $raffle,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Raffle Found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'prize_id' => 'required|max:191',
            'prize_name' => 'required|max:191',
            'ticket' => 'required|max:191',
            'participant' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $raffle = Raffle::find($id);
            if ($raffle) {
                $raffle->prize_id = $request->input('prize_id');
                $raffle->prize_name = $request->input('prize_name');
                $raffle->ticket = $request->input('ticket');
                $raffle->participant = $request->input('participant');

                if ($request->hasFile('image')) {
                    $path = $raffle->image;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/raffle/', $filename);
                    $raffle->image = 'uploads/raffle/' . $filename;
                }

                $raffle->description = $request->input('description');
                $raffle->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Raffle Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Raffle Not Found',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $raffle = Raffle::find($id);
        if ($raffle) {
            $raffle->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Prize Deleted Successfully',

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Prize Id Found',
            ]);
        }
    }

}
