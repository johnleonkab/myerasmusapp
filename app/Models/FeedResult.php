<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedResult extends Model
{
    use HasFactory;

    public $fillable = [
        'type',
        'result_id',
        'visible',
        'public',   
        'owner_id',
        'relevance',
        'slug'
    ];

    public function thread(){
        return $this->belongsTo(Thread::class, 'result_id', 'id');
    }

    public function event(){
        return $this->belongsTo(Event::class, 'result_id', 'id');
    }

    
}
