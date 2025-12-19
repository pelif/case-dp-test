<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\User;
use App\Services\Contracts\RegisteredUserServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

     public function __construct(
        private RegisteredUserServiceInterface $service
    ) {}

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $registered = $this->service->store($request->validated());

        if ($registered)
            return redirect(route('dashboard', absolute: false))->with('success', 'Usuário registrado com sucesso');

        return redirect(route('register', absolute: false))->with('errorRegister', 'Erro ao registrar usuário');
    }
}
