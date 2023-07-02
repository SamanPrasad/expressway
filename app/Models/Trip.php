<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $primaryKey = 'trip_id';

    protected $fillable = [
        'start_at',
        'start_from',
        'destination',
        'route_number',
        'bus_number',
        'driver_id',
        'conductor_id'
    ];

    public function bus(){
        return $this->belongsTo(Bus::class, 'bus_number', 'registration_number');
    }

    public function route(){
        return $this->belongsTo(Route::class, 'route_number', 'route_number');
    }

    public function driver(){
        return $this->belongsTo(User::class, 'driver_id', 'user_id');
    }

    public function conductor(){
        return $this->belongsTo(User::class, 'conductor_id', 'user_id');
    }
}
