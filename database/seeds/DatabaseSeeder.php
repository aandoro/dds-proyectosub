<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LevelsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ChallengesTableSeeder::class);
        $this->call(TriviasTableSeeder::class);
        $this->call(optionsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        //$this->call(SpeciesTableSeeder::class);
        //$this->call(UserMobilesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(ImageSpeciesSeeder::class);
    }
}
