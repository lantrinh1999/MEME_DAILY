<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToMemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memes', function (Blueprint $table) {
            $table->integer('location')->default(1)->comment('1: việt nam; 2: quốc tế');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memes', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
