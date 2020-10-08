<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->text('slug')->unique();
            $table->text('image')->nullable()->default(NULL);
            $table->string('template')->nullable()->default('default');
            $table->enum('status', ['PUBLISH', 'DRAFT'])->nullable()->default('DRAFT');
            $table->string('post_type')->nullable()->default('post');
            $table->bigInteger('user_id')->unsigned()->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}