<?php

namespace App\Services;

use App\Services\Contracts\PasswordServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordService implements PasswordServiceInterface
{
    public function update(array $data): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $updated = $user->update([
            'password' => Hash::make($data['password']),
        ]);

        if (!$updated)
            return false;

        return true;
    }
}
