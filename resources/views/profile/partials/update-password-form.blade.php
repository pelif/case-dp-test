<section class="h-100 d-flex flex-column">
    <header>
        <h2 class="h5 fw-medium text-dark">
            {{ __('Atualizar Senha') }}
        </h2>

        <p class="mt-1 small text-secondary">
            {{ __('Garanta que sua conta esteja usando uma senha longa e aleatória para maior segurança.') }}
        </p>
    </header>

    @if (session('successPassword'))
        <div class="alert alert-success col-12 text-center p-1">{{ session('successPassword') }} </div>
    @endif

    @if (session('errorPassword'))
        <div class="alert alert-danger col-12 text-center p-1">{{ session('errorPassword') }} </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="mt-4 d-flex flex-column h-100">
        @csrf
        @method('put')

        <div class="mb-3">
            <x-input-label for="update_password_current_password" :value="__('Senha Atual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="form-control mt-1" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password" :value="__('Nova Senha')" />
            <x-text-input id="update_password_password" name="password" type="password" class="form-control mt-1"
                autocomplete="new-password"/>
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Senha')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control mt-1" autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="d-flex align-items-center gap-2 mt-auto">
            <x-primary-button>{{ __('Atualizar Senha') }}</x-primary-button>
        </div>
    </form>
</section>
