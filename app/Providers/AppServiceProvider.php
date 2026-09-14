<?php

namespace App\Providers;

use App\Contracts\SmsServiceInterface;
use App\Services\Sms\EskizSmsService;
use App\Services\Sms\LogSmsService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsServiceInterface::class, match (config('sms.driver')) {
            'eskiz' => EskizSmsService::class,
            default => LogSmsService::class,
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The site is only ever served over https://ilm.uzkti.uz in production
        // (the Kerio Control gateway terminates TLS). Force the scheme so
        // asset(), url() and redirects never emit http:// links that a
        // browser on the https page would block as mixed content.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
