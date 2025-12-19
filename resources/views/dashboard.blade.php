<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <div class="card-header bg-white">
                            <h4 class="mb-0 fw-bold">Bem-vindo, {{ Auth::user()->name }}!</h4>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF'"
                                    alt="Avatar" class="img-thumbnail rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div
                                    class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary"
                                    style="width: 50px; height: 50px;">
                                    <svg style="width: 40px; height: 40px;" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            @endif

                            <h5 class="card-title mt-4">Suas Informações</h5>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item p-3">
                                    <strong>Nome:</strong> {{ Auth::user()->name }}
                                </li>
                                <li class="list-group-item p-3 ">
                                    <strong>Email:</strong> {{ Auth::user()->email }}
                                </li>
                                <li class="list-group-item p-3">
                                    <strong>Membro desde:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}
                                </li>
                            </ul>

                            <div class="d-flex gap-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    Editar Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
