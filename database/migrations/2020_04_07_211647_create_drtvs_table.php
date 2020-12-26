<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrtvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drtvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('about')->nullable();
            $table->longText('description')->nullable();
            $table->string('here_more_url')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->UnsignedInteger('sort')->nullable();
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
        Schema::dropIfExists('drtvs');
    }
}
