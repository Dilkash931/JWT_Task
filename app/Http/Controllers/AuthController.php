<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    //to store user data
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'Phone' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']),
            'Status' => $validatedData['Status']
        ]);
    
        $token = auth('api')->login($user);
        // return $this->respondWithToken($token);
        return response()->json([
            'message' => 'You successfully registered.',
            'token'=>$token
        ], 201);
    }
    
    

    //login function
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email or password is not correct.'], 401);
        }

        return response()->json([
            'message' => 'You successfully logged in.'
        ], 201);
    }

   

    //show user details
    public function me()
    {
        return response()->json(auth()->user());
    }

   

    //logout function
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

  
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth('api')->factory()->getTTL() * 60
    //     ]);
    // }
}