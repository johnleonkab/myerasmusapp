<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'file_name',
        'description',
        'owner_id',
        'expriry_date',
        'visible',
    ];


    public function owner(){
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function threads(){
        return $this->belongsToMany(Thread::class, 'image_thread', 'thread_id', 'image_id'); // 1 thread has many image
    }
}
