<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use function GuzzleHttp\default_ca_bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;   //Cache缓存门面
use Log;

class IndexController extends Controller
{
    //开通微信公众平台测试账号
    public function index(){
        //        $result = $this->checkSignature();
        //        if($result){
        //            echo $_GET["echostr"];
        //            exit;
        //        }
        //调用关注/取消关注事件
        $this->responseMsg();
        //调用自定义菜单接口
        $this->createMenu();
    }

    //自定义菜单接口
    public function createMenu(){
        $menu = '{
             "button":[
             {	
                  "type":"click",
                  "name":"今日歌曲",
                  "key":"V1001_TODAY_MUSIC"
              },
              {
                   "name":"菜单",
                   "sub_button":[
                   {	
                       "type":"view",
                       "name":"搜索",
                       "url":"http://www.soso.com"
                    },
                    {
                       "type":"click",
                       "name":"赞一下我们",
                       "key":"V1001_GOOD"
                    }],
               }],
         }';
        $access_token = getToken();
        //自定义菜单的接口调用请求说明
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        curl($url,$menu);
    }
    
    //关注/取消关注事件
    public function responseMsg(){
        //获取微信app 发送过来的数据
        $postStr = file_get_contents("php://input");
        Log::info('==='.$postStr);
        //转化成对象
        $postArray = simplexml_load_string($postStr);

        //判断对象中的类型是否 为事件  %s代表字符串
        if($postArray->MsgType=='event'){
            //判断事件是否为 关注或不关注事件
            if($postArray->Event=='subscribe'){
                //判断扫描带参数二维码事件未关注时
                if(!empty($postArray->EventKey) && isset($postArray->Ticket)){
                    $flag = $postArray->EventKey=='qrscene_2001'?'永久二维码':'临时二维码';
                    $Content = 'hello world'.$flag;
                    responseText($postArray,$Content);
                }else{
                    $array = ['Thank you for your attention','你好','感谢您的关注','吃了没'];
                    $Content = $array[array_rand($array)];
                    responseText($postArray,$Content);
                } 
            }
            //自定义菜单的点击自动回复
            if($postArray->Event=='CLICK'){
                $EventKey = $postArray->EventKey;
                switch($EventKey){
                    case 'V1001_TODAY_MUSIC';
                        $array= ['少年','让我欢喜让我忧'];
                        $Content = $array[array_rand($array)];
                        responseText($postArray,$Content);
                        break;
                    case 'V1001_GOOD';
                        $count = Cache::add('goods', '1')?:Cache::increment('goods');
                        $Content = '点赞人数:'.$count;
                        responseText($postArray,$Content);
                        break;
                    default;
                        break;
                }
            }
            //扫描带参数二维码 用户已关注时
            if($postArray->Event=='SCAN'){
                $flag = $postArray->EventKey=='2001'?'永久二维码':'临时二维码';
                $Content = 'hello world'.$flag;
                responseText($postArray,$Content);
            }
        }elseif($postArray->MsgType=='text'){
            $Content = $postArray->Content;
            switch ($Content){
                case '在吗';
                    $Content = '客官您好,有什么需要帮助的吗?';
                    responseText($postArray,$Content);
                    break;
                    case '在';
                    $Content = '客官您好,有什么需要帮助的吗?';
                    responseText($postArray,$Content);
                    break;
                case '红包';
                    $Content = '哈哈哈';
                    responseText($postArray,$Content);
                    break;
                case '图片';
                    $media_id = 'nvRTq_4p3N-7AunpC4LeC3X7RsI0yPPp3SH3stORVzr4V9nJ9CZlvDioewiq1LWC';
                    reponseImage($postArray,$media_id);
                    break;
                case '图文';
                  $array=[
                      'Title'=>'乐宁教育线下复学',
                      'Description'=>'转校山东',
                      'PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1595218896466&di=886017473fa3aa1afa01f9172fab4681&imgtype=0&src=http%3A%2F%2Fa1.att.hudong.com%2F05%2F00%2F01300000194285122188000535877.jpg',
                      'Url'=>'www.baidu.com',
                ];
                  reposnimg($postArray,$array);
                    break;
                    //默认
                default;
                    $Content = '欢迎';
                    responseText($postArray,$Content);
                    break;
            }
        }
    }

    //开发者通过检验signature对请求进行校验（下面有校验方式）。若确认此次GET请求来自微信服务器
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = config('wechat.Token');
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

    //上传临时图片的方法
    public function uploadimg(Request $request){
        $path = $request->except('_token');
        if ($request->hasFile('img')){
            $path = upload('img');
        }
        $path = storage_path('app/'.$path);
        //dd($path);
        $data = ['media'=>new \CURLFile($path)];  //从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 CURLFile 发送
        //dd($data);
        $access_token = getToken();
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=image";
        $res = $this->curl($url,$data);
        //dd($res);
    }

    //群发的方法
    public function moreSend(){
        $access_token = getToken();
        $url ='https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token='.$access_token;
        //文本
        // $data = '
        //     {     
        //         "touser":"oZDUYwbJGxA3dqvR6fpp82dogpjg",
        //         "text":{           
        //         "content":"感谢您的关注"            
        //         },     
        //         "msgtype":"text"
        //     }';
        //图片
        $data ='
        {
            "touser":"oZDUYwbJGxA3dqvR6fpp82dogpjg",
            "image":{      
             "media_id":"nvRTq_4p3N-7AunpC4LeC3X7RsI0yPPp3SH3stORVzr4V9nJ9CZlvDioewiq1LWC"
            },
            "msgtype":"image" 
        }';
        $res = curl($url,$data);  
        //dd($res);
    }

    //模板消息
    public function templatesend(){
        $access_token = getToken();
        $data='
        {
            "touser":"oZDUYwbJGxA3dqvR6fpp82dogpjg",
            "template_id":"w_xhmfKUCJ4oM87LzJq4TLvjAgEKM1UiEye457sGDJE",
            "url":"http://www.baidu.com",       
            "data":{
                "name":{
                    "value":"小明",
                    "color":"#173177"
                },
                "time":{
                    "value":"'.date('Y-m-d H:i:s').'"
                },
                "money":{
                    "value":"￥10000",
                    "color":"#ff0000"
                }
            }
        }';
        //dd($data);
        $url ='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        $res = curl($url,$data);
        //dd($res);
    }

    //生成二维码的方法
    public function createticket(){
        //1.access_token是公众号的全局唯一接口调用凭据
        $access_token = getToken();
        //2.临时和永久二维码请求说明 url
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        //3.临时二维码 json POST数据例子
        //$data = '{"expire_seconds":604800,"action_name":"QR_SCENE","action_info":{"scene":{"scene_id":2000}}}';
        //4.永久二维码 json POST数据例子
        $data = '{"action_name":"QR_LIMIT_SCENE","action_info":{"scene":{"scene_id":2001}}}';
        //5.curl提交HTTP请求方法
        $res = curl($url,$data);
        //6.将二维码ticket  json串转化成数组
        $ticket = json_decode($res,true);
        //dd($ticket);
        //7.判断
        if(isset($ticket['ticket'])){
            //8.请求说明  并给跳转
            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket['ticket'];
            header('location:'.$url);
        }
    }

    //网页授权
    public function getUserInfo(){
        //授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
        $redirect_uri = urlencode('http://www.gzzxd520.cn/wechat/getuseropenid');
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        //随机取3位数
        $str = substr(str_shuffle($str),0,3);
        //dd($str);
        //1.第一步：用户同意授权，获取code
        //静默授权
        // $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.config('wechat.appID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$str.'#wechat_redirect';
        //普通授权  有允许等
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.config('wechat.appID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state='.$str.'#wechat_redirect';
        //echo $url;
        header('location:'.$url);
        //3.第三步：刷新access_token（如果需要）
        
    }

    //回调地址 静默授权
    public function getuseropenid(){
        //echo 123;
        //2.第二步：通过code换取网页授权access_token  调用接口 
        //本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
        $code = request()->code;
        //echo "===111===";
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.config('wechat.appID').'&secret='.config('wechat.appsecret').'&code='.$code.'&grant_type=authorization_code';
        //echo $url;
        //获取微信app 发送过来的数据
        $result = file_get_contents($url);
        
        //转化成数组
        $result =json_decode($result,true);
        //dd($result);
        //判断
        if($result['scope']==='snsapi_base'){
            //静默授权到此结束
            echo $result['openid'];
            exit;
        }else{
            //普通授权
            //4.第四步：拉取用户信息(需scope为 snsapi_userinfo)
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$result['access_token'].'&openid='.$result['openid'].'&lang=zh_CN';
            //获取微信app 发送过来的数据
            $userinfo = file_get_contents($url);
            //dump($userinfo);
             //转化成数组
            $result = json_decode($userinfo,true);
            dd($result);
        }

       


    }


}

?>
