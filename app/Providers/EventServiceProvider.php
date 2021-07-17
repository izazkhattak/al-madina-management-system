<?php

namespace App\Providers;

use App\Events\ClientReportEvent;
use App\Events\DealerReportEvent;
use App\Listeners\ClientReportListener;
use App\Listeners\DealerReportListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ClientReportEvent::class => [
            ClientReportListener::class,
        ],
        DealerReportEvent::class => [
            DealerReportListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
