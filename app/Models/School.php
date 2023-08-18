<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'locale',
        'description',
        'slug',
        'interest_urls',
        'type',
        'logo_id',
        'country',
        'latitude',
        'longitude',
        'accepts_erasmus',
        'website',
        'location_id',
    ];


    public function images(){
        $this->hasMany(Image::class);
    }

    public function location(){
        $this->belongsTo(Location::class);
    }
}
