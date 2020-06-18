<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Level;
use App\Category;

class ChallengesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('challenges')->insert([
            'name' => 'Desafío del caracol Trofón',
            'description' => 'Debes encontrar y fotografiar 3 caracoles Trofón sin tocarlos.',
            'picCount' => 3,
            'point' => 100,
            'level_id' => 1,
            'category_id' => 2,
        ]);
        DB::table('challenges')->insert([
            'name' => 'Desafío del caracol trompo',
            'description' => 'Debes encontrar y fotografiar 3 caracoles trompo sin tocarlos.',
            'picCount' => 3,
            'point' => 150,
            'level_id' => 1,
            'category_id' => 2,
        ]);
    }
}
