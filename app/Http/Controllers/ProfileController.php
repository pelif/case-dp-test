<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileUploadAvatarRequest;
use App\Services\Contracts\ProfileServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{


    public function __construct(
        private ProfileServiceInterface $service
    ) {}


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', $this->service->edit($request));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $userUpdated = $this->service->update($request);

        if ($userUpdated)
            return Redirect::route('profile.edit')->with('successInfo', 'Usuário alterado com sucesso!');

        return Redirect::route('profile.edit')->with('error', 'Erro ao alterar usuário');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {
        $deleted = $this->service->destroy($request);

        if ($deleted)
            return Redirect::route('profile.edit')->with('message', 'Usuário excluído com sucesso!');

        return Redirect::route('profile.edit')->with('error', 'Erro ao excluir usuário');
    }

    /**
     * Upload the user's avatar.
     */
    public function uploadAvatar(ProfileUploadAvatarRequest $request): RedirectResponse
    {
        $request->validated();
        $uploaded = $this->service->uploadAvatar($request);

        if (!$uploaded)
            return Redirect::route('profile.edit')->with('errorAvatar', 'Erro ao alterar avatar');

        return Redirect::route('profile.edit')->with('successAvatar', 'Avatar alterado com sucesso!');
    }
}
