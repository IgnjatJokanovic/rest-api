<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login()
    {
        $credentials = request()->only(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|alpha_num',
        ]);

        if($validator->fails())
        {
            $errors = array();
            foreach($validator->errors()->all() as $error)
            {
                array_push($errors, $error);
               
            }
            return response()->json(["messages" => $errors], 422);
        }
        else 
        {
            $token = auth()->attempt($credentials);
            if($token)
            {
                return response()->json(['token' => $token]);
            }
            else 
            {
                return response()->json(['messages' => ['Invalid username or password']], 401);
            }
        }

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['messages' =>'Successfully logged out'], 200);
    }
}
