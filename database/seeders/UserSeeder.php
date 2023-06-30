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
                'role'=>'admin'
            ],
            [
                'first_name'=>'Bruce',
                'last_name'=>'Wayne',
                'email'=>'bruce@gmail.com',
                'password'=>'bruce',
                'role'=>'data'
            ],
            [
                'first_name'=>'Barry',
                'last_name'=>'Allen',
                'email'=>'barry@gmail.com',
                'password'=>'barry',
                'role'=>'manager'
            ],
            [
                'first_name'=>'Clark',
                'last_name'=>'Kent',
                'email'=>'clark@gmail.com',
                'password'=>'barry',
                'role'=>'owner'
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }

    }
}
