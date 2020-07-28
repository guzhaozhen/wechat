<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/7/26
 * Time: 19:44
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /*** 关联到模型的数据表 ** @var string */
    protected $table = 'type';
    /*** The primary key associated with the table. ** @var string */
    protected $primaryKey = 't_id';
    /*** 可以被批量赋值的属性. ** @var array */
    // protected $fillable = ['name'];
    /*** 不能被批量赋值的属性** @var array */
    protected $guarded = [];
}