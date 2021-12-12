<?php

namespace App\Http\Controllers\API;

use App\Events\WheelSpin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WheelController extends Controller
{
    public function spin()
    {
        
        event(new WheelSpin(true));

        return [];
    }
}
