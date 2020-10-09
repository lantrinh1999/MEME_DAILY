<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifiledUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('name')->nullable();
            $table->string('username', 32)->unique();
            $table->string('email', 120)->unique();
            $table->string('password')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->boolean('is_active')->nullable()->default(TRUE)->comment('{TRUE,FALSE}');
            $table->boolean('is_super')->nullable()->default(FALSE)->comment('{TRUE,FALSE}');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
