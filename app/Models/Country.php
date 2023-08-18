<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'name',
        'locale',
        'slug',
        'latitude',
        'longitude',
        'flag',
        'interest_urls',
        'description'
    ];
}
