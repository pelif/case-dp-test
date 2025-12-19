<?php

namespace App\Services\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

interface AuthSessionServiceInterface
{
    public function store(LoginRequest $request): void;
    public function destroy(Request $request): bool;
}
