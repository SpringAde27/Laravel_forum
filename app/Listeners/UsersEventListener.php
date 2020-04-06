<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersEventListener
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
    public function handle(Login $event)
    {
        $event->user->last_login = \Carbon\Carbon::now();    

        return $event->user->save();
    }

    /**
     * 이벤트 구독자
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            \App\Events\UserCreated::class,
            __CLASS__ . '@onUserCreated'
        );

        $events->listen(
            \App\Events\PasswordRemindCreated::class,
            __CLASS__ . '@onPasswordRemindCreated'
        );
    }

    public function onUserCreated(\App\Events\UserCreated $event)
    {
        $user = $event->user;
        $view = 'emails.'.app()->getLocale().'.auth.confirm';
        
        \Mail::send(
            $view,
            compact('user'), 
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject(trans('emails.auth.confirm'));
            }
        );
    }

    public function onPasswordRemindCreated(\App\Events\PasswordRemindCreated $event)
    {
        $view = 'emails.'.app()->getLocale().'.passwords.reset';

        \Mail::send(
            $view,
            ['token' => $event->token],
            function ($message) use ($event) {
                $message->to($event->email);
                $message->subject(trans('emails.passwords.reset'));
            }
        );
    }
}
