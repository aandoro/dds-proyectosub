<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'name' => 'generalidades',
            'number' => 1,
            'scoreRequired'=> 200
        ]);

        DB::table('levels')->insert([
            'name' => 'estrella',
            'number' => 2,
            'scoreRequired' => 500

        ]);

        DB::table('levels')->insert([
            'name' => 'eriso',
            'number' => 3,
            'scoreRequired' => 1500

        ]);
        DB::table('levels')->insert([
            'name' => 'coral',
            'number' => 4,
            'scoreRequired' => 3000

        ]);
        DB::table('levels')->insert([
            'name' => 'pulpo',
            'number' => 5,
            'scoreRequired' => 4000

        ]);
        DB::table('levels')->insert([
            'name' => 'crustaceo',
            'number' => 6,
            'scoreRequired' => 6000

        ]);
    }
}
