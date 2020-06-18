<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_species', function (Blueprint $table) {
            $table->engine = 'PostgreSQL';
            $table->bigIncrements('id');
            $table->string('image');
            $table->unsignedInteger('specie_id');
            $table->foreign( 'specie_id')->references('id')->on('species');
            $table->timestamps();
            $table->softDeletes(); //borrado logico
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_species');
    }
}
