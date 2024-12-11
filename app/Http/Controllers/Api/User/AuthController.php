<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\User\LoginRequest;
use App\Http\Requests\Api\Auth\User\RegisterRequest;
use App\Services\Api\User\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json($result, $result['status_code']);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return response()->json($result, $result['status_code']);
    }

    public function logout(): JsonResponse
    {
        $result = $this->authService->logout();
        return response()->json($result, $result['status_code']);
    }
}
