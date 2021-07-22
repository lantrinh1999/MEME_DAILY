<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToMetaBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meta_boxes', function (Blueprint $table) {
            $table->index(['meta_key', 'reference_id', 'reference_type'], 'meta_boxes_meta_key_reference_id_reference_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meta_boxes', function (Blueprint $table) {
            $table->dropIndex(['meta_boxes_meta_key_reference_id_reference_type']);
        });
    }
}
