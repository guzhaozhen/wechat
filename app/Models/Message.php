<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /*** 关联到模型的数据表 ** @var string */
    protected $table = 'message';
    /*** The primary key associated with the table. ** @var string */
    protected $primaryKey = 'u_id';
    /*** 可以被批量赋值的属性. ** @var array */
    // protected $fillable = ['name'];
    /*** 不能被批量赋值的属性** @var array */
    protected $guarded = [];
    /**时间戳 不想要这些望 created_at 和 updated_at */
    public $timestamps = false;
}
