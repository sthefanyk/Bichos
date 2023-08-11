<?php

namespace App\Providers;

use App\Repositories\Eloquent\PersonalidadeEloquentRepository;
use Core\Domain\Repository\PersonalidadeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PersonalidadeRepositoryInterface::class,
            PersonalidadeEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
