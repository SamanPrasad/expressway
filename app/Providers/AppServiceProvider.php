<?php

namespace App\Providers;

use App\Repositories\Bus\BusRepository;
use App\Repositories\Bus\BusRepositoryInterface;
use App\Repositories\Route\RouteRepository;
use App\Repositories\Route\RouteRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(BusRepositoryInterface::class, BusRepository::class);

        $this->app->bind(RouteRepositoryInterface::class, RouteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
