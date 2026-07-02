<?php

namespace App\Providers;

use App\Http\Responses\Auth\LoginResponse;
use App\Http\Responses\Auth\RegistrationResponse;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
        $this->app->bind(RegistrationResponseContract::class, RegistrationResponse::class);
    }

    public function boot(): void
    {
        //
    }
}
