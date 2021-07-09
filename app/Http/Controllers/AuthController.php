<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);


        $token = $user->createToken('auth-Token')->plainTextToken ;

        $response = [
            'user' => $user , 
            'token' => $token
        ];

        return response($response ,201);

    }

    public function login(Request $request){
        $attr = $request->validate([
            // 'email' => 'required|string',
            // 'password' => 'required|string'
        ]);
        $user =  User::where('email',$attr['email'])->first();

        if (!$user || !Hash::check($attr['password'],$user->password )) {
            return response([
                'message' => 'bad creds'
            ],401);
        }

        $token = $user->createToken('user-Token')->plainTextToken ; 

        $response = [
            'user' => $user , 
            'token' => $token
        ];
        return response($response);

    }

    public function logout() {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'logout success'
        ];
    }
}
