<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product')) {
                    Schema::create('product', function (Blueprint $table) {
                        $table->increments('pro_id');
                        $table->string('pro_name')->comment('货物名称');
                        $table->string('pro_img')->comment('货物图');
                        $table->integer('pro_number');
                        $table->integer('addtime');
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
        Schema::dropIfExists('product');
    }
}
