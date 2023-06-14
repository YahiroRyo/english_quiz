<?php

namespace App\Providers;

use Aws\Polly\PollyClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });

        $this->app->bind(PollyClient::class, function () {
            $config = [
                'version' => 'latest',
                'region' => 'ap-northeast-1',
            ];

            return new PollyClient($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
