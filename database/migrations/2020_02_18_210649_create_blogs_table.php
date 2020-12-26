<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('blog_id');
            $table->Integer('blog_cat')->default(0);
            $table->string('blog_title')->nullable();
            $table->text('blog_desc')->nullable();
            $table->string('blog_image')->nullable();
            $table->string('blog_url')->nullable();
            $table->text('blog_meta_key')->nullable();
            $table->text('blog_meta_desc')->nullable();
            $table->Integer('blog_sort')->default(0);
            $table->tinyInteger('blog_publish')->default(0)->comment('0=unpublish, 1 = publish');
            $table->tinyInteger('blog_bn')->default(0)->comment('1=eng');
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
        Schema::dropIfExists('blogs');
    }
}
