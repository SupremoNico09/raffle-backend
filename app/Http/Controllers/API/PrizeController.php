<?php

namespace App\Http\Controllers\API;

use App\Models\Prize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrizeController extends Controller
{

    public function index()
    {
        $prize = Prize::all();
        return response()->json([
            'status'=>200,
            'prize'=>$prize,
        ]);
    }

    public function allprize()
    {
        $prize = Prize::where('availability', 'Yes')->get();
        return response()->json([
            'status'=>200,
            'prize'=>$prize,
        ]);
    }

    public function edit($id)
    {
        $prize = Prize::find($id);
        if($prize)
        {
            return response()->json([
                'status'=>200,
                'prize'=>$prize
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Prize Id Found'
            ]);
        }
    }

    public function store(Request $request)
    {   
            $validator = Validator::make($request->all(), [
                'type'=>'required|max:191',
                'prize_name'=>'required|max:191',
            ]);
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else
            {

            $prize = new Prize;
            $prize->type = $request->input('type');
            $prize->prize_name = $request->input('prize_name');
            $prize->description = $request->input('description');
            $prize->availability = $request->input('availability');
            $prize->save();
            return response()->json([
                    'status'=>200,
                    'message'=>'Prize Added Successfully',

            ]);

        }
    }

    public function update(Request $request, $id)
    {
                $validator = Validator::make($request->all(), [
                    'type'=>'required|max:191',
                    'prize_name'=>'required|max:191',
                ]);
                if($validator->fails())
                {
                    return response()->json([
                        'status'=>422,
                        'errors'=>$validator->messages(),
                    ]);
                }
                else
                {
                    $prize = Prize::find($id);
                    if($prize)
                    {
                        $prize->type = $request->input('type');
                        $prize->prize_name = $request->input('prize_name');
                        $prize->description = $request->input('description');
                        $prize->availability = $request->input('availability');
                        $prize->save();
                        return response()->json([
                                'status'=>200,
                                'message'=>'Prize Updated Successfully',

                        ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'message'=>'No Prize Id Found',
                    ]);
                }
            }
        }

        public function destroy($id)
        {
            $prize = Prize::find($id);
            if($prize)
            {   
                $prize->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Prize Deleted Successfully',

                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Prize Id Found',
                ]);
            }
        }

        
}
