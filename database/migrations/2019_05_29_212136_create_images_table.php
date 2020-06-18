<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->engine = 'PostgreSQL';
            $table->bigIncrements('id');
            $table->string('image');
            $table->double('longitud');
            $table->double('latitud');
            $table->unsignedInteger('challenge_user_id');
            $table->foreign('challenge_user_id')->references('id')->on('challenge_users');
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
        Schema::dropIfExists('images');
    }
}
