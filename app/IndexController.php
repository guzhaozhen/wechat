<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use function GuzzleHttp\default_ca_bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;   //Cache缓存门面

class IndexController extends Controller
{
    //开通微信公众平台测试账号
    public function index(){
        echo 1234;

//        $result = $this->checkSignature();
//        if($result){
//            echo $_GET["echostr"];
//            exit;
//        }
        //$this->responseMsg();
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
                           "url":"http://www.soso.com/"
                        },
                        {
                           "type":"click",
                           "name":"赞一下我们",
                           "key":"V1001_GOOD"
                        }]
                   }]
                 }';
            $access_token = $this->getToken();
           //自定义菜单的接口调用请求说明
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

            $res = $this->curl($url,$menu);
            dd($res);
    }

    //发送HTTP请求的方法
    public function curl($url,$menu){
//        dd($menu);
        //1.初始化
        $ch = curl_init();
        //2.设置
        curl_setopt($ch,CURLOPT_URL,$url);   //设置提交地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);   //设置返回的值是字符串
        curl_setopt($ch,CURLOPT_POST,1);                   //post 提交方式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$menu);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //3.执行
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);

        return $output;
    }

    //获取access_token 接口调用请求说明
    public function getToken(){
//        Cache::flush();
        //获取缓存
        $access_token = Cache::get('access_token');
        if(!$access_token){
            echo '===';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".config('wechat.appID')."&secret=".config('wechat.appsecret');
    //        echo $url;
            $token = file_get_contents($url);
            $token = json_decode($token,true);
            $access_token = $token['access_token'];
            //设置缓存
            Cache::put('access_token',$token['access_token'],$token['expires_in']);
        }
        return $access_token;
    }

    //关注/取消关注事件
    public function responseMsg(){
        $postStr = file_get_contents("php://input");
//        Login::info('==='.$postStr);
        //转化成对象
        $postArray = simplexml_load_string($postStr);

        //判断对象中的类型是否 为事件  %s代表字符串
        if($postArray->MsgType=='event'){
            //判断事件是否为 关注或不关注事件
            if($postArray->Event=='subscribe'){
                $array = ['Thank you for your attention','你好','感谢您的关注','吃了没'];
                $Content = $array[array_rand($array)];
                $this->responseText($postArray,$Content);
            }
        }elseif($postArray->MsgType=='text'){
            $Content = $postArray->Content;
            switch ($Content){
                case '在吗';
                    $Content = '客官您好,有什么需要帮助的吗?';
                    $this->responseText($postArray,$Content);
                    break;
                case '在';
                    $Content = '客官您好,有什么需要帮助的吗?';
                    $this->responseText($postArray,$Content);
                    break;
                case '红包';
                    $Content = '哈哈哈';
                    $this->responseText($postArray,$Content);
                    break;
                case '图片';
                  $array=[
                      'Title'=>'乐宁教育线下复学',
                      'Description'=>'转校山东',
                      'PicUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1595218896466&di=886017473fa3aa1afa01f9172fab4681&imgtype=0&src=http%3A%2F%2Fa1.att.hudong.com%2F05%2F00%2F01300000194285122188000535877.jpg',
                      'Url'=>'www.baidu.com',
                ];
                  $this->reposnimg($postArray,$array);
                    break;
                    //默认
                default;
                    $Content = '欢迎';
                    $this->responseText($postArray,$Content);
                    break;
            }
        }
    }

    //封装图文消息的方法
    public function reposnimg($postArray,$array){
        $CreateTime=time();
        $temple='<xml>
              <ToUserName><![CDATA['.$postArray->FromUserName.']]></ToUserName>
              <FromUserName><![CDATA['.$postArray->ToUserName.']]></FromUserName>
              <CreateTime>'.$CreateTime.'</CreateTime>
              <MsgType><![CDATA[news]]></MsgType>
              <ArticleCount>1</ArticleCount>
              <Articles>
                <item>
                  <Title><![CDATA['.$array['Title'].']]></Title>
                  <Description><![CDATA['.$array['Description'].']]></Description>
                  <PicUrl><![CDATA['.$array['PicUrl'].']]></PicUrl>
                  <Url><![CDATA['.$array['Url'].']]></Url>
                </item>
              </Articles>
            </xml>';
        echo $temple;
    }

  //封装文本方法
    public function responseText($postArray,$Content){
        $ToUserName=$postArray->FromUserName;
        $FromUserName=$postArray->ToUserName;
        $CreateTime=time();
        $MsgType='text';
        $temple = '<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                       </xml>';
        //sprintf指的是字符串格式化命令  先放模板$temple
        $info = sprintf($temple,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Content);
        echo $info;
    }

    //开发者通过检验signature对请求进行校验（下面有校验方式）。若确认此次GET请求来自微信服务器
    private function checkSignature()
    {
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
}
