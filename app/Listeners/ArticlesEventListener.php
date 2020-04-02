<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ArticlesEventListener
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
    public function handle(\App\Events\ArticlesEvent $event)
    {
        $article = $event->article;

          if ($event->action === 'created') {
              $view = 'emails.articles.created';

              \Mail::send(
                  $view,
                  compact('article'),
                  function ($message) {
                      $message->to(config('mail.from.address'));
                      $message->subject(sprintf('[%s] 새로운 글이 등록되었습니다.', config('project.name')));
                  }
              );
          }

        // if($event->action === 'created') {
        //     \Log::info(sprintf(
        //         '새로운 포럼 글이 등록되었습니다. : %s',
        //         $event->article->title
        //     ));
        // }
    }
}
