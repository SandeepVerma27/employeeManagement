<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $validator = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required',
        //     'role' => 'required|in:admin,user',
        // ]);

        // $user = User::create([
        //     'name' => $validated['name'],
        //     'email' => $validated['email'],
        //     'password' => Hash::make($validated['password']),
        //     'role' => $validated['role'],
        // ]);

        // $token = JWTAuth::fromUser($user);

        // return response()->json(['token' => $token], 201);


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'error' => $validator->errors()
            ], 412);
        }

        $data = $validator->validate();
        $data['password'] = Hash::make($request->password);
        $user = User::insert($data);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not created !'
        ], 500);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'user logged in successfully',
                'token' => $token
            ]
        );
    }
}
