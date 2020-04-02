<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * 이벤트 채널과 이벤트 리스너 등록
     * @var array
     */
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\UsersEventListener::class,
        ],
        \App\Events\ArticlesEvent::class => [
            \App\Listeners\ArticlesEventListener::class,
        ],
        \App\Events\CommentsEvent::class => [
            \App\Listeners\CommentsEventListener::class,
        ],
        \App\Events\ModelChanged::class => [
            \App\Listeners\CacheHandler::class,
        ],
    ];

    /**
     * 이벤트 구독자
     * 하나의 리스너가 여러 개의 이벤트를 구독하고 이벤트를 처리할 수 있다.
     */
    protected $subscribe = [
        \App\Listeners\UsersEventListener::class,
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
