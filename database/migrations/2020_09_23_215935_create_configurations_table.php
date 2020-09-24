<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Configuration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->string('id', 20)->nullable(false);
            $table->boolean('default')->default(false);
            $table->string('current_gif_provider', 20)->nullable(false);
            $table->integer('search_term_min_length');
            $table->integer('max_results_to_show')->default(5);
            $table->string('default_request_protocol', 5)->default('https');
            $table->primary('id');
            $table->foreign('current_gif_provider')->references('identifier')->on('gif_providers');
        });

        Configuration::factory()->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
