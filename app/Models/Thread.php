<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'main_thread',
        'parent_thread_id',
        'content',
        'image_id',
        'slug',
        'user_id',
        'likes',
        'public',
    ];

    public function images(){
        return $this->belongsToMany(Image::class, 'image_thread', 'image_id', 'thread_id'); // 1 thread has many image
    }

    public function owner(){
        return $this->belongsTo(User::Class, 'user_id', 'id');
    }


    public function comments(){
        return $this->hasMany(Thread::class, 'parent_thread_id', 'id')->where('main_thread', 0);
    }

    public function result(){
        return $this->belongsTo(FeedResult::class, 'id', 'result_id')->where('type', 'threads');
    }
}
