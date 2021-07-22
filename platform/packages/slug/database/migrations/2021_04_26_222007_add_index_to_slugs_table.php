<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToSlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->index(['reference_id'], 'slugs_reference_id');
            $table->index(['reference_id', 'reference_type'], 'slugs_reference_id_reference_type');
            $table->index(['key', 'prefix'], 'slugs_key_prefix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->dropIndex(['slugs_reference_id']);
            $table->dropIndex(['slugs_reference_id_reference_type']);
            $table->dropIndex(['slugs_key_prefix']);

        });
    }
}
