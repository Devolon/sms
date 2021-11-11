<?php

namespace Devolon\Sms;

use Devolon\Common\Bases\Repository;
use Devolon\Sms\Repositories\SmsMessageRepository;
use Devolon\Sms\Services\Contracts\SMSSenderServiceInterface;
use Devolon\Sms\Services\ResolveSMSSenderService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->tag(SmsMessageRepository::class, Repository::class);
        $this->app->singleton(ResolveSMSSenderService::class, function (Application $application) {
            /** @var SMSSenderServiceInterface[] $smsSenders */
            $smsSenders = $application->tagged(SMSSenderServiceInterface::class);

            $senders = [];
            foreach ($smsSenders as $smsSender) {
                $senders[$smsSender::getName()] = $smsSender;
            }

            return new ResolveSMSSenderService($senders);
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
