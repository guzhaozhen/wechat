<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    /*** 关联到模型的数据表 ** @var string */ 
    protected $table = 'record'; 
    /*** The primary key associated with the table. ** @var string */ 
    protected $primaryKey = 'r_id';
    /*** 可以被批量赋值的属性. ** @var array */ 
    // protected $fillable = ['name'];
    /*** 不能被批量赋值的属性** @var array */ 
    protected $guarded = [];
    /**时间戳 不想要这些望 created_at 和 updated_at */
    public $timestamps = false;
}
