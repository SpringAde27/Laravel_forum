<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'user_id',
        'parent_id',
        'content',
    ];

    protected $hidden = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'parent_id',
    ];

    protected $with = [
        'user',
        'votes'
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'up_count',
        'down_count',
    ];

    /* Relationships */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    /* (get) 접근자 - Accessors */
    public function getUpCountAttribute()
    {
        return (int) $this->votes()->sum('up');
    }

    public function getDownCountAttribute()
    {
        return (int) $this->votes()->sum('down');
    }
}
