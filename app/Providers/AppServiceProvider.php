<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\WalletRepositoryInterface;
use App\Repositories\WalletRepository;
use App\Interfaces\MerchantRepositoryInterface;
use App\Repositories\MerchantRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
            $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
    );

    $this->app->bind(
    WalletRepositoryInterface::class,
    WalletRepository::class
);

        $this->app->bind(
    MerchantRepositoryInterface::class,
    MerchantRepository::class
);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
