<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Contracts\AuthSessionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSessionService implements AuthSessionServiceInterface
{
    public function store(LoginRequest $request): void
    {
        $request->authenticate();

        $request->session()->regenerate();
    }

    public function destroy(Request $request): bool
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return true;
    }
}
