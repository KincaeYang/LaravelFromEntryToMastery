<?php

namespace App\Providers;

use App\Listeners\UserInfoEventSubscriber;
use App\Observers\UsersObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Users;

class EventServiceProvider extends ServiceProvider
{

    //注册监听的订阅者
    protected $subscribe = [
        UserInfoEventSubscriber::class
    ];
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
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

        Users::observe(UsersObserver::class);
        //
    }
}
