<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->text('designation')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('instragram_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('email_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('photo')->nullable();
            $table->tinyInteger('status');
            $table->integer('sort')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('our_teams');
    }
}
