<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GifProviderKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gif_provider_keyword', function (Blueprint $table) {
            $table->id()->nullable(false)->autoIncrement();
            $table->string('keyword_value', 100);
            $table->string('gif_provider_identifier', 20);
            $table->integer('calls');
            $table->foreign('gif_provider_identifier')->references('identifier')->on('gif_providers');
            $table->foreign('keyword_value')->references('value')->on('keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
