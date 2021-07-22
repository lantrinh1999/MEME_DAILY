<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MemeCreateMemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('description', 500)->nullable();
            $table->text('content')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('meme_slug')->nullable();
            $table->text('meme_meta')->nullable();
            $table->string('type', 100)->nullable();
            $table->bigInteger('author_id')->nullable()->default(0)->unsigned();
            $table->string('author_type')->nullable();
            $table->string('status', 60)->default('published');
            $table->string('locate', 60)->default('vn');
            $table->bigInteger('view')->nullable()->default(0);
            $table->tinyInteger('is_hidden')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('meme_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('description', 500)->nullable();
            $table->text('content')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('type', 100)->nullable();
            $table->bigInteger('author_id')->nullable()->default(0)->unsigned();
            $table->string('author_type')->nullable();
            $table->string('status', 60)->default('published');
            $table->tinyInteger('is_hidden')->nullable()->default(0);
            $table->string('locate', 60)->default('vn');
            $table->bigInteger('view')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('meme_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meme_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('meme_id')->nullable()->references('id')->on('memes')->onDelete('cascade');
            $table->foreign('tag_id')->nullable()->references('id')->on('meme_tags')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memes');
        Schema::dropIfExists('meme_tags');
        Schema::dropIfExists('meme_tag');
    }
}
