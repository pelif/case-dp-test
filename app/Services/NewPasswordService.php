<?php

namespace App\Services;

use App\Http\Requests\NewPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Services\Contracts\NewPasswordServiceInterface;

class NewPasswordService implements NewPasswordServiceInterface
{
    public function store(NewPasswordRequest $request): bool
    {
        $status = Password::reset(
            $request->validated(),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET;
    }
}
