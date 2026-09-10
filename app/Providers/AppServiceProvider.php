<?php

namespace App\Providers;

use App\Contracts\SmsServiceInterface;
use App\Services\Sms\EskizSmsService;
use App\Services\Sms\LogSmsService;
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
        //
    }
}
