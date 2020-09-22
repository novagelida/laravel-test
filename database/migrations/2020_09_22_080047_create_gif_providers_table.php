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
            $table->string('slug');
            $table->text('description');
            $table->integer('calls');
            $table->json('credentials');
            $table->primary('slug');
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
