<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_section_test_item', function (Blueprint $table) {
            $table->integer('exam_section_id')->unsigned();
            $table->foreign('exam_section_id')->references('id')->on('exam_sections')->onDelete('cascade');
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
        Schema::dropIfExists('exam_section_test_item');
    }
}
