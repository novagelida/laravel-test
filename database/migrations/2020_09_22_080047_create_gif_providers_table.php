<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGifProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gif_providers', function (Blueprint $table) {
            //TODO: slug must have just lowercase letters and underscores
            $table->string('identifier', 20);
            $table->text('description');
            $table->integer('calls');
            $table->json('credentials');
            $table->string('research_endpoint');
            $table->enum('research_strategy', ['basicTenor', 'basicGiphy'])->default('basicTenor');
            $table->enum('formatter', ['fromTenorToArray', 'fromGiphyToArray'])->default('fromTenorToArray');
            $table->primary('identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gif_providers');
    }
}
