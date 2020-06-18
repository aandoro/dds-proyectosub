<?php

use Illuminate\Database\Seeder;
use App\Level;
use App\Category;

class TriviasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trivias')->insert([
            'name' => 'Trivia 1',
            'description' => 'En la trivia se te hara una pregunta, en donde tendras que responder por multiple choice, responde correctamente y tendras puntos si tienen un usuario en la aplicacion',
            'point' => rand(1, 150),
            'question' => "Las estrellas de mar son un grupo de:",
            'optCorrect' => "equinodermos",
            'level_id' => 1,
            'category_id' => Category::all()->random()->id,
        ]);
        DB::table('trivias')->insert([
            'name' => 'Trivia 2',
            'description' => 'En la trivia se te hara una pregunta, en donde tendras que responder por multiple choice, responde correctamente y tendras puntos si tienen un usuario en la aplicacion',
            'point' => rand(1, 150),
            'question' => "¿Qué características comparten las almejas, mejillones y vieiras?",
            'optCorrect' => "presentan dos valvas",
            'level_id' => 1,
            'category_id' => Category::all()->random()->id,
        ]);
        DB::table('trivias')->insert([
            'name' => 'Trivia 3',
            'description' => 'En la trivia se te hara una pregunta, en donde tendras que responder por multiple choice, responde correctamente y tendras puntos si tienen un usuario en la aplicacion',
            'point' => rand(1, 150),
            'question' => "Los ambientes intermareales son ambientes que:",
            'optCorrect' => "representan mucho estrés para los invertebrados marinos",
            'level_id' => 1,
            'category_id' => Category::all()->random()->id,
        ]);
        DB::table('trivias')->insert([
            'name' => 'Trivia 4',
            'description' => 'En la trivia se te hara una pregunta, en donde tendras que responder por multiple choice, responde correctamente y tendras puntos si tienen un usuario en la aplicacion',
            'point' => rand(1, 150),
            'question' => "Los equinodermos son un grupo:",
            'optCorrect' => "exclusivamente marinos",
            'level_id' => 1,
            'category_id' => Category::all()->random()->id,
        ]);
    }
}
