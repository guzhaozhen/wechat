<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Record;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**搜索 */
        $pro_name = request()->pro_name;
        $where = [];
        if($pro_name){
            $where [] = ['pro_name','like',"$pro_name"];
        }
        $pageSize = config('app.pageSize');
        $goodsInfo = Product::where($where)->orderBy('pro_id','desc')->paginate($pageSize);

        if(request()->ajax()){
            return view('exam.product.ajaxindex',['goodsInfo'=>$goodsInfo,'pro_name'=>$pro_name]);
        }
        return view('exam.product.index',['goodsInfo'=>$goodsInfo,'pro_name'=>$pro_name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();  //开启事务
        try{
                $post = $request->except('_token');
                $post['addtime'] = time();
                if ($request->hasFile('pro_img')) {
                    $post['pro_img'] = upload('pro_img');
                }
                $res = Record::insert($post);

            DB::commit();  //事务提交
        }catch(Exception  $e) {
            echo $e->getMessage();   //返回错误信息
            DB::rollBack();   //回滚事务
        }
             if($res){
                    return redirect('exam/product/index');
                }
    }

    /**入库出库视图 */
    public function stock($type,$pro_id){
        // echo $type.'-'.$pro_id;
        $goodsInfo = Product::find($pro_id);
        return view('exam.product.stock',['goodsInfo'=>$goodsInfo,'type'=>$type]);
    }

    /**执行出库出库 */
    public function delivery(Request $request,$type,$pro_id){
        DB::beginTransaction();  //开启事务
        try{
                $post_number = $request->pro_number;
                $pro_number = Product::find($pro_id)->value('pro_number');
                // dump($post_number);
                //增加
                if($type==1){
                    $res = Product::where('pro_id',$pro_id)->increment('pro_number',$post_number);
                }

                //把出入库需要的数据传入到出入库表中  日志
                $data = [
                    'admin_id'=>session('admin')->admin_id,
                    'pro_id'=>$pro_id,
                    'types'=>$type,
                    'number'=>$post_number,
                    'addtime'=>time()
                ];
                //入库 出入表的
                Record::insert($data);

                //减少
                if($type==2){
                    $res = Product::where('pro_id',$pro_id)->decrement('pro_number',$post_number);
                }
            DB::commit();  //事务提交
        }catch(Exception  $e) {
            echo $e->getMessage();   //返回错误信息
            DB::rollBack();   //回滚事务
        }


        if($res){
            return redirect('exam/product/index');
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
        //
    }
}
