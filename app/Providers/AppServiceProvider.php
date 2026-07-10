<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\WalletRepositoryInterface;
use App\Repositories\WalletRepository;
use App\Interfaces\MerchantRepositoryInterface;
use App\Repositories\MerchantRepository;
use App\Interfaces\MerchantApiKeyRepositoryInterface;
use App\Repositories\MerchantApiKeyRepository;
use App\Interfaces\PaymentOrderRepositoryInterface;
use App\Repositories\PaymentOrderRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


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

        $this->app->bind(
    MerchantApiKeyRepositoryInterface::class,
    MerchantApiKeyRepository::class
);


        $this->app->bind(
            PaymentOrderRepositoryInterface::class,
            PaymentOrderRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            RateLimiter::for('auth-api', function (Request $request) {
        return Limit::perMinute(5)
            ->by($request->ip());
    });

    RateLimiter::for('wallet-api', function (Request $request) {
        return Limit::perMinute(30)
            ->by($request->user()?->id ?: $request->ip());
    });

    RateLimiter::for('merchant-payment-api', function (Request $request) {
        return Limit::perMinute(60)
            ->by($request->header('X-API-KEY') ?: $request->ip());
    });
    }
}
