<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemeMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meme_meta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('meme_id')->unsigned()->nullable()->default(NULL);
            $table->string('key')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
            $table->foreign('meme_id')->nullable()->references('id')->on('memes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meme_meta');
    }
}