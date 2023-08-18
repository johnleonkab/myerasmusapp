<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'start_datetime',
        'end_datetime',
        'origin_country_id',
        'origin_school_id',
        'destination_country_id',
        'destination_school_id',

    ];

    public function home_country(){
        return $this->belongsTo(Country::class, 'origin_country_id', 'id');   
    }

    public function home_school(){
        return $this->belongsTo(School::class, 'origin_school_id', 'id');   
    }

    public function destination_country(){
        return $this->belongsTo(Country::class, 'destination_country_id', 'id');   
    }
    public function destination_school(){
        return $this->belongsTo(School::class, 'destination_school_id', 'id');   
    }


}
