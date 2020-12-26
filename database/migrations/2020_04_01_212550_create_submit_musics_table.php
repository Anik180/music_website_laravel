<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmitMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submit_musics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title_1')->nullable();
            $table->text('url_1')->nullable();
            $table->text('title_2')->nullable();
            $table->text('url_2')->nullable();
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
        Schema::dropIfExists('submit_musics');
    }
}
