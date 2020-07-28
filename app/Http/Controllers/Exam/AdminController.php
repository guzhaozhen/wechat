<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\StoreAdminPost;  //引入验证
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /**搜索 */
       $admin_name = request()->admin_name;
       $role_id = request()->role_id;
       $where = [];
       if($admin_name){
           $where [] = ['admin_name','like',"%$admin_name%"];
       } 
       if($role_id){
        $where [] = ['role_id',$role_id];
      } 

       $pageSize = config('app.pageSize');

       $adminInfo = Admin::where($where)->orderBy('admin_id','desc')->paginate($pageSize);

       if(request()->ajax()){
           return view('exam.admin.ajaxindex',['adminInfo'=>$adminInfo,'admin_name'=>$admin_name,'role_id'=>$role_id]);
       }

       return view('exam.admin.index',['adminInfo'=>$adminInfo,'admin_name'=>$admin_name,'role_id'=>$role_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminPost $request)
    {
        $post = $request->except('_token');

        // if($post['admin_pwd']!=$post['admin_repwd']){
        //     return redirect('exam/admin/create')->with('msg','两次密码不一致');
        // }
        
        unset($post['admin_pwd_confirmation']);
        $post['admin_pwd'] = encrypt($post['admin_pwd']);

        if ($request->hasFile('admin_img')) {
             $post['admin_img'] = upload('admin_img');
        }

        //添加入库
        $res = Admin::create($post);
        if($res){
            return redirect('exam/admin/index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $res = Admin::destroy($id);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'删除成功']);
        }
    }

    public function checkname(){
        // $admin_name = request()->admin_name;
        // echo $admin_name;
    }
}
