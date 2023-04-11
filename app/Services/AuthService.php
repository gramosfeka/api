<?php

namespace App\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;



class AuthService
{
    public function login(array $data)
    {
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return (object)( [
                'status' => 'error',
                'message' =>     'Login credentials are invalid',
                'user' => $user ?? null,
            ]);
        }

        $user = Auth::user();

        return (object)([
            'status' => 'success',
            'message' =>'You are logged in',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
       ]);

    }

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        event(new Registered($user));

        $token = JWTAuth::attempt(['email' => $data['email'], 'password' => $data['password']]);

        return (object)([
            'status' => 'success',
            'message' => 'User created successfully and verification email has been sent',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(true);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

}
