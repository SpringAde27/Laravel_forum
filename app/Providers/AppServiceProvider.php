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
        // 런타임에 기본 언어를 오버라이딩
        // app()->setLocale('en');

        if ($locale = request()->cookie('my__locale')) {
            // 암호화된 쿠키를 복호화한 후 적용할 언어를 설정
            app()->setLocale(\Crypt::decrypt($locale));
        }

        // 카본 인스턴스의 언어를 설정
        \Carbon\Carbon::setLocale(app()->getLocale());

        // 뷰 컴포저
        view()->composer('*', function($view) {
            $allTags = \Cache::rememberForever('tags.list', function() {
                return \App\Tag::all();
            });

            $currentUser = auth()->user();
            $currentRouteName = \Route::currentRouteName();
            $currentLocale = app()->getLocale();
            $currentUrl = current_url();
            // $currentUrl = request()->fullUrl();
            
            $view->with(compact('allTags', 'currentUser', 'currentRouteName', 'currentLocale', 'currentUrl'));
        });
    }
}
