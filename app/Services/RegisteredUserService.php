<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\RegisteredUserServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserService implements RegisteredUserServiceInterface
{
    use UploadAvatar;

    public function store(array $data): bool
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($user instanceof User) {
            event(new Registered($user));
            Auth::login($user);

            // if (isset($data['avatar'])) {
            //     $path = $this->upload($data['avatar'], $user->id);
            //     $user->avatar = $path;
            //     $user->save();
            // }

            return true;
        }

        return false;
    }
}
