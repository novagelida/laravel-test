<?php

use App\Models\GifProvider;
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
            //TODO: 20 might be a little restrictive, I'm just having a go
            $table->string('identifier', 20);
            $table->text('description');
            $table->integer('calls');
            $table->json('credentials');
            $table->enum('research_strategy', ['basicTenor'])->default('basicTenor');
            $table->primary('identifier');
        });

        GifProvider::factory()->create();
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
