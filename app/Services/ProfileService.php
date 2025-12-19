<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUploadAvatarRequest;
use App\Services\Contracts\ProfileServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceInterface
{
    public function edit(Request $request): array
    {
        return [
            'user' => $request->user(),
        ];
    }

    public function update(ProfileUpdateRequest $request): bool
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        return $request->user()->save();
    }

    public function destroy(ProfileDeleteRequest $request): bool
    {
        $request->validated();
        $user = $request->user();

        Auth::logout();

        $deleted = $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $deleted;
    }

    public function uploadAvatar(ProfileUploadAvatarRequest $request): bool
    {
        $user = $request->user();

        if ($request->hasFile('avatar')) {

            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            if ($user->save())
                return true;
        }

        return false;
    }

}
