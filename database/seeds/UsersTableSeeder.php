<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'point' => 0,
            'password' => Hash::make('admin'),
            'role' => 2
        ]);
        User::create([
            'name' => 'User',
            'surname' => 'User',
            'username' => 'user',
            'email' => 'user@test.com',
            'point' => 0,
            'password' => Hash::make('secret'),
            'role' => 1
        ]);
        /* User::create([
            'name' => 'Adrian',
            'surname' => 'Andoro',
            'username' => 'kbe',
            'point' => rand(0, 500),
            'email' => 'kbeandoro@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]);
        User::create([
            'name' => 'Daiana',
            'surname' => 'Penchuelef',
            'username' => 'Daiana',
            'point' => rand(0, 500),
            'email' => 'daiana@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]);
        User::create([
            'name' => 'Fabian',
            'surname' => 'Paredes',
            'username' => 'Fabi',
            'point' => rand(0, 500),
            'email' => 'fabiani@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]);
        User::create([
            'name' => 'Mauricio',
            'surname' => 'Savarro',
            'username' => 'Oruga',
            'point' => rand(0, 500),
            'email' => 'oruga.gritona@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]);
        User::create([
            'name' => 'Emanuel',
            'surname' => 'Balcazar',
            'username' => 'Ema',
            'point' => rand(0, 500),
            'email' => 'el.ema@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]);
        User::create([
            'name' => 'Francisco',
            'surname' => 'Gigena',
            'username' => 'Pancho',
            'point' => rand(0, 500),
            'email' => 'colimba@gmail.com',
            'password' => Hash::make('password'),
            'role' => 3
        ]); */
    }
}
