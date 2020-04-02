<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confirm_code', 'activated', 'name', 'email', 'password', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'confirm_code', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'activated' => 'boolean'
    ];

    // 모델에 접근할 때, 카본 인스턴스로 받을 수 있다.
    protected $dates = ['last_login'];

    // 쿼리스코프 : 반복되는 쿼리 조각
    public function scopeSocialUser(\Illuminate\Database\Eloquent\Builder $query, $email)
    {
        return $query->whereEmail($email)->whereNull('password');
    }

    // 모델 관계 연결
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // 모델에 없는 프로퍼티도 접근자로 만들 수 있다.
    // public function getGravatarUrlAttribute()
    // {
    //     return sprintf("//www.gravatar.com/avatar/%s?s=%s", md5($this->email), 48);
    // }

    /* Helpers */
    public function isAdmin()
    {
       return $this->id === 1;
    }
}
