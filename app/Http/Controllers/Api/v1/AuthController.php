<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(
            $request->validated()
        );

        return $this->successResponse(
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'User registered successfully',
            201
        );
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->validated()
        );

        return $this->successResponse(
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'User logged in successfully'
        );
    }

    public function profile(Request $request)
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'User profile fetched successfully'
        );
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->successResponse(
            null,
            'User logged out successfully'
        );
    }
}