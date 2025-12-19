<section class="h-100 d-flex flex-column">
    <header>
        <h2 class="h5 fw-medium text-dark">
            {{ __('Informações de Perfil') }}
        </h2>

        <p class="mt-1 small text-secondary">
            {{ __("Atualize as informações do seu perfil e endereço de e-mail.") }}
        </p>
    </header>

    @if (session('successInfo'))
        <div class="alert alert-success py-1 col-12 text-center">Perfil alterado com sucesso.</div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="mt-4 d-flex flex-column h-100">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" name="name" type="text" class="form-control mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" name="email" type="email" class="form-control mt-1" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="d-flex align-items-center gap-2 mt-auto">
            <x-primary-button>{{ __('Salvar Informações de Perfil') }}</x-primary-button>
        </div>
    </form>
</section>
