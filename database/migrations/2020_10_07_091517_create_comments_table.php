<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('author_name')->nullable();
            $table->string('author_mail')->nullable();
            $table->text('content')->nullable();
            $table->nestedSet();
            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
            $table->enum('status', ['PUBLISH', 'HIDDEN'])->nullable()->default('PUBLISH');
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
        Schema::dropIfExists('comments');
    }
}