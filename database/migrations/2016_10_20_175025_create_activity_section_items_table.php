<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_section_test_item', function (Blueprint $table) {
            $table->integer('activity_section_id')->unsigned();
            $table->foreign('activity_section_id')->references('id')->on('activity_sections')->onDelete('cascade');
            $table->integer('test_item_id')->unsigned();
            $table->foreign('test_item_id')->references('id')->on('test_items')->onDelete('cascade');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_section_test_item');
    }
}
