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
    
        return response()->json([
            'response' => [
                'message' => 'You successfully registered.',
                'status' => 201
            ]
        ], 201);
    }
    
    

    //login function
    public function login()
    {
        $credentials = request(['email', 'password']);
    
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'response' => [
                    'message' => 'Email or password is not correct.',
                    'status' => 401
                ]
            ], 401);
        }
    
        return response()->json([
            'response' => [
                'message' => 'You successfully logged in.',
                'status' => 200,
                'token' => $token
            ]
        ], 200);
    }
    
   

    //show user details
    public function me()
    {
        return response()->json([
            'response' => [
                'message' => 'User details retrieved successfully.',
                'status' => 200,
                'data' => auth()->user()
            ]
        ], 200);
    }
    
   

    //logout function
    public function logout()
    {
        auth()->logout();
    
        return response()->json([
            'response' => [
                'message' => 'Successfully logged out.',
                'status' => 200
            ]
        ], 200);
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