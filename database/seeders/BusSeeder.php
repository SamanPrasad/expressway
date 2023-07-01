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
                'registration_number'=>'SP-23445',
                'type'=>'A/C',
                'capacity'=>50
            ],
            [
                'registration_number'=>'SP-28545',
                'type'=>'Normal',
                'capacity'=>40
            ],
            [
                'registration_number'=>'WP-23445',
                'type'=>'A/C',
                'capacity'=>25
            ],
        ];

        foreach($buses as $bus){
            Bus::create($bus);
        }
    }
}
