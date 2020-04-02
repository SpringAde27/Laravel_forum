<?php

namespace App\Listeners;

use App\Events\ModelChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheHandler
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
     * @param  ModelChanged  $event
     * @return void
     */
    public function handle(ModelChanged $event)
    {
        if (! taggable()) {
          // 태깅이 불가능한 캐시 저장소의 캐시를 전부 삭제
          return \Cache::flush();
        }

        // 캐시 태그에 해당하는 캐시만 삭제
        return \Cache::tags($event->cacheTags)->flush();
    }
}
