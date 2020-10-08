<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemeCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meme_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meme_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('meme_id')->nullable()->references('id')->on('memes')->onDelete('cascade');
            $table->foreign('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meme_category');
    }
}