<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
           $user = $this->authService->login($request->validated());
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }

        return new LoginResource($user);

    }

    public function register(RegisterRequest $request)
    {
        try {
         $user = $this->authService->register($request->validated());

        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }

        return new RegisterResource($user);

    }

    public function logout()
    {
        try {
           return $this->authService->logout();
        } catch (\Exception $exception) {

            return $this->errorResponse($exception);
        }

    }

}
