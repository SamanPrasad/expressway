<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses = [
            [
                'registration_number'=>'SP23445',
                'type'=>'ac',
                'capacity'=>50
            ],
            [
                'registration_number'=>'SP28545',
                'type'=>'normal',
                'capacity'=>40
            ],
            [
                'registration_number'=>'WP23445',
                'type'=>'ac',
                'capacity'=>25
            ],
        ];

        foreach($buses as $bus){
            Bus::create($bus);
        }
    }
}
