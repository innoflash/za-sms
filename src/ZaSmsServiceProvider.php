<?php

namespace Innoflash\ZaSms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Innoflash\ZaSms\Contracts\BulkSMSProviderContract;
use Innoflash\ZaSms\Contracts\SMSProviderContract;
use Innoflash\ZaSms\Exceptions\ClassException;
use Innoflash\ZaSms\Utils\Config;
use Innoflash\ZaSms\Utils\SMSProviders;

class ZaSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/za-sms.php', 'za-sms');
        $this->publishThings();
        $this->register();
        $this->setUpProviders();

        // $this->loadViewsFrom(__DIR__.'/resources/views', 'za-sms');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->registerRoutes();
    }

    private function setUpProviders()
    {
        $provider = Config::getProvider();
        $this->app->singleton(SMSProviderContract::class, function () use ($provider) {
            return new SMSProviders::$smsProviders[$provider];
        });

        $this->app->singleton(BulkSMSProviderContract::class, function () use ($provider) {
            $className = str_replace('SMSProviders\\', 'SMSProviders\\Bulk\\', SMSProviders::$smsProviders[$provider]);
            if (!class_exists($className))
                throw ClassException::bulkProviderException($provider, $className);
            return new $className();
        });
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    /**
     * Get the Blogg route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "Innoflash\ZaSms\Http\Controllers",
            'middleware' => 'api',
            'prefix'     => 'api'
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        $this->app->singleton('za-sms', function () {
            return new ZaSmsFacade;
        });
    }

    public function publishThings()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/za-sms.php' => config_path('za-sms.php'),
            ], 'za-sms-config');
        }
    }
}
