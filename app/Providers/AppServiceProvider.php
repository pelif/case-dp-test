<?php

namespace App\Providers;

use App\Services\AuthSessionService;
use App\Services\ConfirmablePasswordService;
use App\Services\Contracts\AuthSessionServiceInterface;
use App\Services\Contracts\ConfirmablePasswordServiceInterface;
use App\Services\Contracts\NewPasswordServiceInterface;
use App\Services\Contracts\ProfileServiceInterface;
use App\Services\Contracts\RegisteredUserServiceInterface;
use App\Services\NewPasswordService;
use App\Services\RegisteredUserService;
use App\Services\ProfileService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\PasswordServiceInterface;
use App\Services\PasswordService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);

        $this->app->bind(RegisteredUserServiceInterface::class, RegisteredUserService::class);

        $this->app->bind(AuthSessionServiceInterface::class, AuthSessionService::class);

        $this->app->bind(ConfirmablePasswordServiceInterface::class, ConfirmablePasswordService::class);

        $this->app->bind(NewPasswordServiceInterface::class, NewPasswordService::class);

        $this->app->bind(PasswordServiceInterface::class, PasswordService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'local') {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
        }
    }
}
