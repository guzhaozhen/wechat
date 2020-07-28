<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Admin;
use Illuminate\Support\Facades\Redis;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //搜索
        $u_name = request()->u_name;
//        dd($u_name);
        $page = request()->page;
        $where = [];
        if($u_name){
            $where [] = ['u_name','like',"%$u_name%"];
        }
//        Redis::flushall();
        $messageInfo = Redis::get('messageInfo_'.$u_name.'_'.$page);
//        dd($messageInfo);

        if(!$messageInfo){
            echo "DB==";
            $pageSize = config('app.pageSize');
            $messageInfo = Message::join('admin','message.admin_id','=','admin.admin_id')->where($where)->orderBy('u_id','desc')->paginate($pageSize);

            $messageInfo = serialize($messageInfo);
            Redis::setex('messageInfo_'.$u_name.'_'.$page,60,$messageInfo);
        }
        $messageInfo = unserialize($messageInfo);

        //访问量
        $visitor = Redis::setnx('visitor_'.$messageInfo['u_id'],1)?:Redis::incr('visitor_'.$messageInfo['u_id']);

        return view('exam.message.index',['messageInfo'=>$messageInfo,'u_name'=>$u_name,'visitor'=>$visitor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('exam.message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token');
        $admin_id = session('admin')->admin_id;
        $post['u_name']=session('admin')->admin_name;
         //dd($admin_id);
        $post['admin_id'] = $admin_id;


        $post['addtime'] = time();

        $res = Message::insert($post);
        if($res){
            return redirect('exam\message\index');
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
        $res = Message::destroy($id);
        if($res){
            echo  json_encode(['code'=>'1','msg'=>'删除成功']);
        }
    }
}
