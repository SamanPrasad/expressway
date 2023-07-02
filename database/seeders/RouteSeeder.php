<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            [
                'route_number'=>'413/2',
                'from'=> 'Galle',
                'to'=>'Matara'
            ],
            [
                'route_number'=>'2',
                'from'=> 'Matara',
                'to'=>'Colombo'
            ],
            [
                'route_number'=>'10',
                'from'=> 'Matara',
                'to'=>'Ratnapura'
            ],
            [
                'route_number'=>'1',
                'from'=> 'Colombo',
                'to'=>'Kandy'
            ],
            [
                'route_number'=>'3',
                'from'=> 'Colombo',
                'to'=>'Kataragama'
            ],
            [
                'route_number'=>'40',
                'from'=> 'Kandy',
                'to'=>'Ratnapura'
            ],
            [
                'route_number'=>'23',
                'from'=> 'Matara',
                'to'=>'Banadarawela'
            ],
        ];

        foreach($routes as $route){
            Route::create($route);
        }
    }
}
