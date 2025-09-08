<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\Auth\AuthServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->authService->register($data);
            return response()->json($result, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->authService->login($data);
            return response()->json($result);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request->user());
            return response()->json(['message' => 'Logged out successfully']);
        } catch (Exception) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
