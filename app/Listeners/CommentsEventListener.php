<?php

namespace App\Listeners;

use App\Events\CommentsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentsEventListener
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
     * @param  CommentsEvent  $event
     * @return void
     */
    public function handle(CommentsEvent $event)
    {
        $comment = $event->comment;
        $comment->load('commentable'); // 지연로드
        $to = $this->recipients($comment);

        if(! $to) {
            return;
        }

        \Mail::send('emails.comments.created', compact('comment'),
            function ($message) use ($to) {
                $message->to($to);
                $message->subject(
                    sprintf('[%s] 새로운 댓글이 등록되었습니다.', config('project.name'))
                );
            });
    }

    private function recipients(\App\Comment $comment)
    {
        static $to = [];

        if($comment->parent) {
            $to[] = $comment->parent->user->email;

            $this->recipients($comment->parent);
        }

        if($comment->commentable->notification) {
            $to[] = $comment->commentable->user->email;
        }

        return array_unique($to);
    }
}
