<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterRequest $request)
    {
        $data = $request->validated();
        $result = $this->authService->register($data);
        return response()->json($result, 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $data = $request->validated();
        $result = $this->authService->login($data);
        return response()->json($result);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'Logged out successfully']);
    }
}
