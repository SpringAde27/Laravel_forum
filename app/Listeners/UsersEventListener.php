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
        
        \Mail::send('emails.auth.confirm', compact('user'), 
        function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(sprintf('[%s] 회원가입을 확인해 주세요.', config('project.name')));
        });
    }

    public function onPasswordRemindCreated(\App\Events\PasswordRemindCreated $event)
    {
        \Mail::send(
            'emails.passwords.reset',
            ['token' => $event->token],
            function ($message) use ($event) {
                $message->to($event->email);
                $message->subject(
                    sprintf('[%s] 비밀번호를 초기화하세요.', config('project.name'))
                );
            }
        );
    }
}
