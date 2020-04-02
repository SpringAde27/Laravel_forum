<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 전역등록(config/app.php)을 하지 않고 환경에 따라 서비스 프로바이더 등록
        if($this->app->environment('local')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 뷰 컴포저
        view()->composer('*', function($view) {
            $allTags = \Cache::rememberForever('tags.list', function() {
                return \App\Tag::all();
            });
            
            $view->with( compact('allTags') );
        });
    }
}
