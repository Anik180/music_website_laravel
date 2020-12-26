<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpickArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epick_artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('about');
            $table->longText('description')->nullable();
            $table->string('music_speciality');
            $table->string('facebook')->nullable();
            $table->string('instragram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('itunes')->nullable();
            $table->string('bandcamp')->nullable();
            $table->string('disk_download')->nullable();
            $table->string('spotify')->nullable();
            $table->string('apple_music')->nullable();
            $table->string('sound_cloud')->nullable();
            $table->string('website')->nullable();
            $table->string('here_more_url')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->UnsignedInteger('sort')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epick_artists');
    }
}
