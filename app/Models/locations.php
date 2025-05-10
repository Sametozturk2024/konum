<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class locations extends Model
{
    protected $fillable= [
        'user_id',
        'name',
        'latitude',
        'longitude',
        'marker_color',
        'description',
        'orders',
    ];



}
