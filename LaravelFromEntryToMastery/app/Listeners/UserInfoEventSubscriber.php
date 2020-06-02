<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserDeleted;
use App\Events\UserDeleting;
use Illuminate\Support\Facades\Log;

class UserInfoEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    //处理删除前的事件
    public function onUserDeleting($event)
    {
        Log::info('用户记录即将被删除【'.$event->user_info->id.'】');
    }


    //处理删除后的事件
    public function onUserDeleted($event)
    {
        Log::info('用户记录被删除【'.$event->user_info->id.'】');
    }


    //为订阅者注册监听
    public function subscribe($events)
    {
        $events->listen(
            UserDeleting::class,
            UserInfoEventSubscriber::class . '@onUserDeleting'
        );

        $events->listen(
            UserDeleted::class,
            UserInfoEventSubscriber::class . '@onUserDeleted'
        );
    }

}
