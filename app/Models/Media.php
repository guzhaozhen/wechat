<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
     /*** 关联到模型的数据表 ** @var string */
        protected $table = 'media';
        /*** The primary key associated with the table. ** @var string */
        protected $primaryKey = 'm_id';
        /*** 可以被批量赋值的属性. ** @var array */
        // protected $fillable = ['name'];
        /*** 不能被批量赋值的属性** @var array */
        protected $guarded = [];
}
