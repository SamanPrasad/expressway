<?php

namespace Database\Seeders;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            [
                'start_at'=>Carbon::parse('2023-11-01 15:04:19'),
                'start_from'=>'Colombo',
                'destination'=>'Kandy',
                'route_number'=>13,
                'bus_number'=> 'SP23445',
                'driver_id'=>5,
                'conductor_id'=>6,
            ],
            [
                'start_at'=>Carbon::parse('2023-11-01 15:04:19'),
                'start_from'=>'Colombo',
                'destination'=>'Galle',
                'route_number'=>13,
                'bus_number'=> 'SP28545',
                'driver_id'=>17,
                'conductor_id'=>26,
            ],
            [
                'start_at'=>Carbon::parse('2023-11-01 15:04:19'),
                'start_from'=>'Colombo',
                'destination'=>'Ratnapura',
                'route_number'=>13,
                'bus_number'=> 'WP23445',
                'driver_id'=>11,
                'conductor_id'=>21,
            ],
        ];

        foreach($trips as $trip){
            Trip::create($trip);
        }
    }
}
