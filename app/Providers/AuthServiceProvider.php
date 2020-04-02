<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // 콜백에 담긴 처리 로직을 별도의 클래스로 추춯한 권한 부여 로직-정책
        // $this->registerPolicies();

        // 최고 관리자 권한, before메서드는 다른 권한 검사 처리 전에 먼저 실행
        Gate::before(function ($user) {
            if ($user->isAdmin()) return true;
        });

        // 권한부여 및 처리 로직
        Gate::define('update', function($user, $model) {
            return $user->id === $model->user_id;
        });
        
        Gate::define('delete', function($user, $model) {
            return $user->id === $model->user_id;
        });
    }
}
