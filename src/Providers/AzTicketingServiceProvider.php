<?php
namespace AntonioPedro99\Azticketing\Providers;

use Illuminate\Support\ServiceProvider;
use AntonioPedro99\Azticketing\Services\AzTicketingAzureDevOpsService;
use AntonioPedro99\Azticketing\Services\AzTicketingManagerService;

class AzTicketingServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        if(config('azticketing.enable_views')){
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'azticketing');
        }

        $this->publishes([
            __DIR__ . '/../config/azticketing.php' => config_path('azticketing.php'),
        ], 'azticketing-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/azticketing.php', 'azticketing');

        $this->app->singleton(AzTicketingAzureDevOpsService::class, function () {
            return new AzTicketingAzureDevOpsService();
        });

        $this->app->singleton('AzTicketingManager', function ($app) {
            return new AzTicketingManagerService($app->make(AzTicketingAzureDevOpsService::class));
        });
    }
}
