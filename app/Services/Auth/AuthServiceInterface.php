<?php
namespace App\Services\Auth;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): array;
    public function login(array $data): array;
    public function logout(User $user): void;
}

