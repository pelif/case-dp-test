<section class="h-100 d-flex flex-column">
    <header>
        <h2 class="h5 fw-medium text-dark">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 small text-muted">
            {{ __("Altere seu avatar.") }}
        </p>
    </header>

    @if (session('successAvatar'))
        <div class="alert alert-success col-12 text-center p-1">{{ session('successAvatar') }} </div>
    @endif

    @if (session('errorAvatar'))
        <div class="alert alert-danger col-12 text-center p-1">{{ session('errorAvatar') }} </div>
    @endif

    <form
        method="post"
        action="{{ route('profile.upload_avatar') }}"
        class="mt-4 d-flex flex-column h-100"
        enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col d-flex align-items-center gap-3 mb-3">
                @if ($user->avatar)
                <img
                    src="{{ asset('storage/' . $user->avatar) }}"
                    alt="{{ $user->name }}"
                    class="img-thumbnail rounded-circle"
                    style="width: 80px; height: 80px; object-fit: cover;">
                @else

                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary w-12 h-12">
                    <svg style="width: 40px; height: 40px;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                @endif

                <div class="flex-grow-1">
                    <x-input-label for="avatar" :value="__('Avatar')" />
                    <input id="avatar" name="avatar" type="file" class="form-control mt-1" accept="image/*" />
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mt-auto">
            <x-primary-button>{{ __('Alterar Avatar') }}</x-primary-button>
        </div>
    </form>
</section>
