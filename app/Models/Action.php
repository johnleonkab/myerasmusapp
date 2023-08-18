<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'action',
        'target_type',
        'target_id'
    ];


    public function thread(){
        return $this->belongsTo(Thread::class, 'target_id', 'id');
    }

    public function event(){
        return $this->belongsTo(Event::class, 'target_id', 'id');
    }

}
