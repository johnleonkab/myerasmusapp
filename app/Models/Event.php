<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'location_id',
        'category_id',
        'image_id',
        'slug',
        'start_datetime',
        'end_datetime',
        'owner_id',
        'public',
    ];

    public function image(){
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function result(){
        return $this->belongsTo(FeedResult::class, 'id', 'result_id')->where('type', 'events');
    }
}
