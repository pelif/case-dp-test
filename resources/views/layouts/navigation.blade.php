<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top"
                style="height: 30px; width: auto; fill: currentColor;" />
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Users Deep') }}
                </x-nav-link>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Profile Link -->
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Perfil') }}
                </x-nav-link>

                <!-- Logout -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link text-white-50 hover-text-white"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Sair') }}
                        </a>
                    </form>
                </li>

                <!-- Settings Link -->
                <x-nav-link>
                    @if (Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                            class="img-thumbnail rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div
                            class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary w-12 h-12">
                            <svg style="width: 40px; height: 40px;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    @endif
                </x-nav-link>
            </ul>
        </div>
    </div>
</nav>
