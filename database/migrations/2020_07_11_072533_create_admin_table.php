<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('admin')){ 
                Schema::create('admin', function(Blueprint $table){
                $table->increments('admin_id');
                $table->string('admin_name')->comment('用户名');
                $table->string('admin_pwd');
                $table->tinyInteger('role_id')->default(1);
                $table->string('admin_img');
                $table->timestamps();
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
        Schema::dropIfExists('admin');
    }
}
