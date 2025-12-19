<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="form-control"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-sm text-gray-600">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="d-flex flex-column align-items-center justify-content-start mt-4">

            <x-primary-button>
                {{ __('Entrar') }}
            </x-primary-button>


            @if (Route::has('password.request'))
            <a class="text-decoration-none text-muted me-3 mt-4" href="{{ route('password.request') }}">
                {{ __('Esqueceu sua Senha ?') }}
            </a>
            @endif

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-decoration-none text-muted">
                {{ __('Crie uma Conta') }}
            </a>
            @endif

    </form>
</x-guest-layout>
