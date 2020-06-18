<?php

use App\UserMobile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserMobilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserMobile::create([
            'name' => 'Adrian',
            'surname' => 'Andoro',
            'username' => 'kbe',
            'point' => rand(0, 500),
            'email' => 'kbeandoro@gmail.com',
            'password' => Hash::make('password')
        ]);
        UserMobile::create([
            'name' => 'Daiana',
            'surname' => 'Penchuelef',
            'username' => 'Daiana',
            'point' => rand(0, 500),
            'email' => 'daiana@gmail.com',
            'password' => Hash::make('password')
        ]);
        UserMobile::create([
            'name' => 'Fabian',
            'surname' => 'Paredes',
            'username' => 'Fabi',
            'point' => rand(0, 500),
            'email' => 'fabiani@gmail.com',
            'password' => Hash::make('password')
        ]);
        UserMobile::create([
            'name' => 'Mauricio',
            'surname' => 'Savarro',
            'username' => 'Oruga',
            'point' => rand(0, 500),
            'email' => 'oruga.gritona@gmail.com',
            'password' => Hash::make('password')
        ]);
        UserMobile::create([
            'name' => 'Emanuel',
            'surname' => 'Balcazar',
            'username' => 'Ema',
            'point' => rand(0, 500),
            'email' => 'el.ema@gmail.com',
            'password' => Hash::make('password')
        ]);
        UserMobile::create([
            'name' => 'Francisco',
            'surname' => 'Gigena',
            'username' => 'Pancho',
            'point' => rand(0, 500),
            'email' => 'colimba@gmail.com',
            'password' => Hash::make( 'password')
        ]);
    }
}
