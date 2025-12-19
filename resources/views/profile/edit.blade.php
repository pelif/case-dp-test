<x-app-layout>
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-12">
                <h2 class="h4 fw-semibold text-dark mb-4">
                    {{ __('Perfil') }}
                </h2>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="p-4 bg-white shadow-sm rounded w-100">
                    @include('profile.partials.update-avatar-form')
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="p-4 bg-white shadow-sm rounded w-100">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="p-4 bg-white shadow-sm rounded w-100">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
