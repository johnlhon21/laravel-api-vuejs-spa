<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\Repositories\AuthClientRepository;
use App\Repositories\Contracts\AuthClientRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Services\Api\Authentication\Authentication;
use App\Services\Api\Authentication\AuthenticationContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\UserService;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Services
        $this->app->bind(AuthenticationContract::class, Authentication::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

        //Repositories
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(AuthClientRepositoryContract::class, AuthClientRepository::class);
    }
}
