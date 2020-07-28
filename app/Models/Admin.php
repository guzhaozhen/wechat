<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /*** 关联到模型的数据表 ** @var string */ 
    protected $table = 'admin'; 
    /*** The primary key associated with the table. ** @var string */ 
    protected $primaryKey = 'admin_id';
    /*** 可以被批量赋值的属性. ** @var array */ 
    // protected $fillable = ['name'];
    /*** 不能被批量赋值的属性** @var array */ 
    protected $guarded = [];
    
}
