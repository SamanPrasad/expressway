<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name'=>'Saman',
                'last_name'=>'Prasad',
                'email'=>'saman@gmail.com',
                'password'=>'saman',
                'role'=>'Admin'
            ],
            [
                'first_name'=>'Bruce',
                'last_name'=>'Wayne',
                'email'=>'bruce@gmail.com',
                'password'=>'bruce',
                'role'=>'Data Entry'
            ],
            [
                'first_name'=>'Barry',
                'last_name'=>'Allen',
                'email'=>'barry@gmail.com',
                'password'=>'barry',
                'role'=>'Manager'
            ],
            [
                'first_name'=>'Clark',
                'last_name'=>'Kent',
                'email'=>'clark@gmail.com',
                'password'=>'barry',
                'role'=>'Owner'
            ],
            [
                'first_name'=>'Steve',
                'last_name'=>'Rogers',
                'email'=>'steve@gmail.com',
                'role'=>'Driver'
            ],
            [
                'first_name'=>'Tony',
                'last_name'=>'Stark',
                'email'=>'stark@gmail.com',
                'role'=>'Conductor'
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }

    }
}
