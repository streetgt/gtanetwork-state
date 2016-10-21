<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UpdateServerEvent' => [
            'App\Listeners\UpdateServerList',
        ],
        'App\Events\UpdateServerStatisticsEvent' => [
            'App\Listeners\UpdateServerStatistics',
        ],
        'App\Events\UpdateServerInfoEvent' => [
            'App\Listeners\UpdateServerInfo',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
