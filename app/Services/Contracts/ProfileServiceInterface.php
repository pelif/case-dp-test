<?php

namespace App\Services\Contracts;

use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileUploadAvatarRequest;
use Illuminate\Http\Request;

interface ProfileServiceInterface
{
    public function edit(Request $request): array;
    public function update(ProfileUpdateRequest $request): bool;
    public function destroy(ProfileDeleteRequest $request): bool;
    public function uploadAvatar(ProfileUploadAvatarRequest $request): bool;
}
