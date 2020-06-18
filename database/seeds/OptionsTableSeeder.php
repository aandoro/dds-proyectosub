<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class optionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            'option' => "moluscos",
            'trivia_id' => 1,
        ]);

        DB::table('options')->insert([
            'option' => "equinodermos",
            'trivia_id' => 1,
        ]);

        DB::table('options')->insert([
            'option' => "crustáceos",
            'trivia_id' => 1,
        ]);

        DB::table('options')->insert([
            'option' => "tienen una concha",
            'trivia_id' => 2,
        ]);

        DB::table('options')->insert([
            'option' => "presentan dos valvas",
            'trivia_id' => 2,
        ]);

        DB::table('options')->insert([
            'option' => "presentan cirros",
            'trivia_id' => 2,
        ]);

       
        DB::table('options')->insert([
            'option' => "representan mucho estrés para los invertebrados marinos",
            'trivia_id' => 3,
        ]);

        DB::table('options')->insert([
            'option' => "se encuentran sumergidos ",
            'trivia_id' => 3,
        ]);

        DB::table('options')->insert([
            'option' => "solo son de fondos duros ",
            'trivia_id' => 3,
        ]);

        DB::table('options')->insert([
            'option' => "que presentan rádula",
            'trivia_id' => 4,
        ]);
        DB::table('options')->insert([
            'option' => "exclusivamente marinos",
            'trivia_id' => 4,
        ]);

        DB::table('options')->insert([
            'option' => "se alimentan mediante tentáculos",
            'trivia_id' => 4,
        ]);

    }
}
