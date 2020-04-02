<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * 즉시로드 사용 
     * 1. with('관계_이름')
     * 2. 엘로퀀트 프로퍼티를 이용 _ 반드시 필요할 때만 사용 ($article->user)
     * @var array
     */
    protected $with = [
        'user',
    ];
}
