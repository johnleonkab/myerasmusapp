<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'name',
        'type', // city, region, café..
        'slug',
        'locale',
        'latitude',
        'longitude',
        'country_id',
        'parent_location_id',
        'interest_urls',
        'description'
    ];

    public function country(){
        $this->belongsTo(Country::class);
    }
}
