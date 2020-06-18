<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 1,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 2,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 3,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 4,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 5,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 6,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 7,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 8,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 9,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 10,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 11,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 12,
        ]);
        DB::table('image_species')->insert([
            'image' => "default_specie.jpg",
            'specie_id' => 13,
        ]);
    }
}
