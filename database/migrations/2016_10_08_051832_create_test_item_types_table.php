<?php

use App\TestItemType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_item_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        TestItemType::create(['name'=>'identification']);
        TestItemType::create(['name'=>'mutiple choice']);
        TestItemType::create(['name'=>'true or false']);
        TestItemType::create(['name'=>'enumeration']);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_item_types');
    }
}
