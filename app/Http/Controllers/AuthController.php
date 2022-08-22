<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\PseudoTypes\True_;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields= $request->validate([
            'name'=>'required|string|',
            'email'=>'required|email|string|unique:Users,email',
            'password'=> 'required|confirmed|string'
        ]);
        // if($fields)
        //     $user=User::create();

    $user=User::create([
        'name'=>$fields['name'],
        'email'=>$fields['email'],
        'password'=>bcrypt($fields['password']),

    ]);
        $token = $user->createToken('MyAppToken')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token,
        ];
        return response($response, 201);
    }
    public function authenticate(Request $request)
    {
        $fields = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email', $fields['email'])->first();
        if(!$user|| Hash::check($fields['password'],$user->password))
            return response(['message'=>'wrong data'],401);
        $token = $user->createToken('MyAppToken')->plainTextToken;
        $response = [
                'user'=>$user,
                'token'=>$token,
            ];
            return response($response, 201);
    }

public function logout(Request $request)
{
        auth()->user()->tokens()->delete();
        return ['message'=>'you are logged out',200];
}

}
