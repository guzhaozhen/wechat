<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('record')) {
                    Schema::create('record', function (Blueprint $table) {
                        $table->increments('r_id');
                        $table->tinyInteger('admin_id')->comment('用户id');
                        $table->tinyInteger('pro_id')->comment('货物id');
                        $table->tinyInteger('types')->comment('1:入库 2:出库');
                        $table->integer('addtime')->comment('操作时间');
                        $table->integer('number')->comment('出入库数量');
                        $table->engine = 'InnoDB';
                });
            }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record');
    }
}
