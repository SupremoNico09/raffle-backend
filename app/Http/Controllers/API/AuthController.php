<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'=>'required|max:191',
            'lastname'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users,email',
            'password'=>'required|min:8', 
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
               'validation_errors'=>$validator->messages(), 
            ]);
        } 
        else 
        {
            $user = User::create([
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role_as'=>$request->role_as,
            ]);

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status'=>200, 
                'username'=>$user->name, 
                'firstname'=>$user->firstname, 
                'token'=>$token, 
                'message'=>'Registered Successfully', 
             ]);

        }
        
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|max:191',
            'password'=>'required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(), 
             ]);
        } 
        else 
        {
            
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=> 401,
                    'message'=> 'Invalid Credentials',
                 ]);
            }
            else
            {
                if ($user->role_as == 1) //1-Admin 
                {
                    $role = 'admin';
                    $token = $user->createToken($user->email.'_AdminToken', ['server:admin'])->plainTextToken;
                } 
                else 
                {   
                    $role = '';
                    $token = $user->createToken($user->email.'_Token', [''])->plainTextToken;
                }
                

                return response()->json([
                    'status'=>200, 
                    'username'=>$user->name,
                    'firstname'=>$user->firstname, 
                    'token'=>$token, 
                    'message'=>'Logged In Successfully', 
                    'role'=>$role,
                 ]);
    
            }
        
        }
        
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logged Out Successfully',
        ]);
    }

}
