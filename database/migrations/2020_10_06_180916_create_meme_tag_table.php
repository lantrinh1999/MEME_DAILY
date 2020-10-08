<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemeTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meme_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meme_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            // $table->timestamps();
            $table->foreign('meme_id')->nullable()->references('id')->on('memes')->onDelete('cascade');
            $table->foreign('tag_id')->nullable()->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meme_tag');
    }
}