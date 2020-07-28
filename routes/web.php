<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

 
 Route::prefix('exam')->middleware('login')->group(function(){
 /**管理员*/    
    Route::get('admin/index','Exam\AdminController@index');  //展示
    Route::get('admin/create','Exam\AdminController@create');  //添加
    Route::post('admin/store','Exam\AdminController@store');   //执行添加
    Route::get('admin/edit/{id}','Exam\AdminController@edit');  //修改视图
    Route::post('admin/update/{id}','Exam\AdminController@update');  //执行修改
    Route::get('admin/destroy/{id}','Exam\AdminController@destroy');  //删除
    Route::get('admin/checkname','Exam\AdminController@checkname');   //js验证唯一
     /**货物管理*/
    Route::get('product/index','Exam\ProductController@index');  //展示
    Route::get('product/create','Exam\ProductController@create');  //添加
    Route::post('product/store','Exam\ProductController@store');   //执行添加
    Route::get('product/stock/{pro_id}/{type}','Exam\ProductController@stock');   //入库出库视图
    Route::post('product/delivery/{pro_id}/{type}','Exam\ProductController@delivery');   //执行出库出库       

     /**出入库记录管理*/
     Route::get('record/index','Exam\RecordController@index');  //展示

     //留言
     Route::get('message/index','Exam\MessageController@index');  //展示
     Route::get('message/create','Exam\MessageController@create');  //添加
     Route::any('message/store','Exam\MessageController@store');   //执行添加
     Route::get('message/destroy/{id}','Exam\MessageController@destroy');  //删除

});

/**登录 */
Route::get('admin/login','Exam\LoginController@index');  //登录
Route::post('admin/logindo','Exam\LoginController@logindo');  //执行登录

//微信开发
//Route::any('/wechat','Wechat\IndexController@index');
//Route::view('/wechat/img','wechat.img');    //显示添加素材模板
//Route::any('/wechat/uploadimg','Wechat\IndexController@uploadimg');  //执行临时图片上传
//
//Route::any('/wechat/moresend','Wechat\IndexController@moreSend');      //群发接口
//Route::any('/wechat/templatesend','Wechat\IndexController@templateSend');      //模板消息
//Route::any('/wechat/createticket','Wechat\IndexController@createticket');      //生成二维码
//Route::any('/wechat/getuser','Wechat\IndexController@getUserInfo');      //网页授权
//Route::any('/wechat/getuseropenid','Wechat\IndexController@getuseropenid');      ///回调地址


//微信项目
Route::any('/wexin','WeXin\IndexController@index');
Route::any('/wexin/create','WeXin\IndexController@create');    //显示添加素材模板
Route::any('/wexin/store','WeXin\IndexController@store');  //执行
Route::any('/wexin/list','WeXin\IndexController@list');  //展示素材
Route::any('/wexin/deletepast','WeXin\IndexController@deletepast');  ////定时任务 定时删除


Route::any('/wexin/createticket','WeXin\IndexController@createticket');      //生成二维码