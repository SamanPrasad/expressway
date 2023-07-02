<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;


    protected $fillable = [
        'route_number',
        'from',
        'to'
    ];

    public function trips(){
        return $this->hasMany(Trip::class, 'route_number', 'route_number');
    }
}
