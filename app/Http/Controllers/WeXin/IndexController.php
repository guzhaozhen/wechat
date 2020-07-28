<?php

namespace App\Http\Controllers\WeXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use App\Models\Media;
use App\Models\Type;
class IndexController extends Controller
{
    //开通微信公众平台测试账号
    public function index(){
        //echo 123;
               $result = $this->checkSignature();
               if($result){
                   echo $_GET["echostr"];
                   exit;
               }
    }

     //开发者通过检验signature对请求进行校验（下面有校验方式）。若确认此次GET请求来自微信服务器
     private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = config('wexin.Token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    //定时任务 定时删除
//    public function deletepast(){
//       Log::info('这是一个测试任务');
//       $time = time();
//       $pageSize = config('app.pageSize');
//        $mediaInfo = Media::join('type','media.t_id','=','type.t_id')
//            ->Orderby('m_id','desc')->paginate($pageSize);
//        $ids = $url = [];
//        foreach($mediaInfo as $key=>$value){
//            if($time-$value->addtime>3*24*60*60){
//                $urls[$key] = $value->m_img;
//                $ids[$key] = $value->m_id;
//            }
//        }
//       // dd($ids);
//       // 文件删除 (阿里云 如果是永久素材记得删除微信服务器的)
//        foreach($urls as $v){
//            $path = storage_path('app/'.$v);
//            if(file_exists($path)){
//                unlink($path);
//            }
//        }
//        删除
//        $res = Media::destory($ids);
//        if($res){
//            Log::info('删除素材成功主键ID为:'.implode(','.$ids));
//        }
//
//    }

    public function create(){
        $typeInfo = Type::get();
        return view('wexin.create',['typeInfo'=>$$typeInfo]);
    }
}
