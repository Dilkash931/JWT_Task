<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Store user data
    public function register(UserRequest $request)
    {
        // The same validation rules for registration will be applied
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'Phone' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']),
            'Status' => $validatedData['Status']
        ]);

        return new UserResource($user, 'register');
    }

    // Login function
    public function login(UserRequest $request)
    {
        // The same validation rules for login will be applied
        $credentials = $request->only('email', 'password');
        
        if (! $token = auth('api')->attempt($credentials)) {
            // Return the failure response
            return new UserResource([], 'login'); // Pass empty array and functionName 'login' for failure
        }
        
        // Return the success response with token
        return new UserResource(['token' => $token], 'login'); // Pass token and functionName 'login'
    }

    // Show user details
    public function me()
    {
        return new UserResource(auth()->user(), 'me');
    }

    // Logout function
    public function logout()
    {
        auth()->logout();

        return new UserResource(null, 'logout');
    }
}

// class AuthController extends Controller
// {
//     // Store user data
//     public function register(RegisterRequest $request)
//     {
//         $validatedData = $request->validated();

//         $user = User::create([
//             'name' => $validatedData['name'],
//             'email' => $validatedData['email'],
//             'Phone' => $validatedData['phone'],
//             'password' => bcrypt($validatedData['password']),
//             'Status' => $validatedData['Status']
//         ]);

//         return new UserResource($user, 'register');
//     }

//     // Login function
//     public function login(LoginRequest $request)
// {
//     $credentials = $request->only('email', 'password');
    
//     if (! $token = auth('api')->attempt($credentials)) {
//         // Return the failure response
//         return new UserResource([], 'login'); // Pass empty array and functionName 'login' for failure
//     }
    
//     // Return the success response with token
//     return new UserResource(['token' => $token], 'login'); // Pass token and functionName 'login'
// }
    
//     // public function login(Request $request)
//     // {
//     //     // Validate the request
//     //     $validated = $request->validate([
//     //         'email' => 'required|email',
//     //         'password' => 'required|string',
//     //     ]);
    
//     //     // Attempt to authenticate the user
//     //     if (!$token = auth('api')->attempt($validated)) {
//     //         return new UserResource('Email or password is not correct.', 'login');
//     //     }
    
//     //     // Return the token wrapped in UserResource
//     //     return new UserResource($token, 'login');
//     // }
    

//     // Show user details
//     public function me()
//     {
//         return new UserResource(auth()->user(), 'me');
//     }

//     // Logout function
//     public function logout()
//     {
//         auth()->logout();

//         return new UserResource(null, 'logout');
//     }
// }

  
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',

    //         'expires_in' => auth('api')->factory()->getTTL() * 60
    //     ]);
    // }
