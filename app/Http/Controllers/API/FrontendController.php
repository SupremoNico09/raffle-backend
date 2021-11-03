<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function prize()
    {
        $prize = Prize::where('availability','Yes')->get();
        return response()->json([
            'status'=>200,
            'prize'=>$prize, 
        ]);
    }
}
