<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * 마이그레이션에서 $table->timestamps()를 쓰지 않으면
     * (created_at, updated_at 열 제외)
     * $timestamps = false; 프로퍼티 값을 줘야한다.
     */
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'comment_id',
        'up',
        'down',
        'voted_at',
    ];

    protected $visible = [
        'user_id',
        'up',
        'down',
    ];

    /* Carbon인스턴스로 쓰기위해 $dates 프로퍼티 값 사용 */
    protected $dates = [
        'voted_at',
    ];

    /* Relationships */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* (set) 변경자 - Mutators */
    public function setUpAttribute($value)
    {
        $this->attributes['up'] = $value ? 1 : null;
    }

    public function setDownAttribute($value)
    {
        $this->attributes['down'] = $value ? 1 : null;
    }
}
