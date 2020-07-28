<?php 

use Illuminate\Support\Facades\Cache;   //Cache缓存门面

/**文件上传的方法 */
function upload($filename){
    // echo $filename;
    // dd(request()->file($filename)->isValid());
    //1.使用 isValid 方法判断文件在上传过程中是否出错：
    if (request()->file($filename)->isValid()){
        //2.接收文件
        $file = request()->$filename;
        // dd($file);
        //3.生成唯一的id 返回路径$path
        $path = request()->$filename->store('uploads');
        return $path;
    }
    return '文件上传过程出错';
}

/**多文件上传 */
function Moreupload($filename){
    $files = request()->$filename;

    if(!count($files)){
        return; 
    }
    foreach($files as $k=>$v){
        $path[] = $v->store('uploads');
    }
    return $path;
}

//curl提交HTTP请求方法 四步 1 初始化  2设置 3执行 4关闭
function curl($url,$menu){
    //初始化 此步骤不可更改
    $ch = curl_init();
    //设置
    curl_setopt($ch, CURLOPT_URL, $url);  //设置提交地址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //将返回值设置为字符串类型，否则可能会以html页面形式返回
    curl_setopt($ch, CURLOPT_POST, 1); //提交方式  POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $menu); //提交数据
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不执行https ssl加密
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不执行https ssl加密
    //执行 curl
    $output = curl_exec($ch);
    if(curl_errno($ch)){
        return curl_error($ch);
    }
    //关闭
    curl_close($ch);
    //返回
    return $output;
}

//access_token是公众号的全局唯一接口调用凭据  调用接口的方法
function getToken()
{
        $access_token=Cache::get('access_token');
        if(!$access_token){
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.config("wechat.appID").'&secret='.config("wechat.appsecret");
            //将文件读入一个字符串
            $token=file_get_contents($url);
            //将json转化
            $token=json_decode($token,true);
            //获取access_token
            $access_token=$token['access_token'];
            //存储access_token
            Cache::put('access_token',$access_token,$token['expires_in']);
        }
        //返回
        return $access_token;
   }

   
//封装文本方法
function responseText($postArray,$Content)
{
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

//封装临时图片的方法
function reponseImage($postArray,$media_id)
{
        $temple='<xml>
          <ToUserName><![CDATA['.$postArray->FromUserName.']]></ToUserName>
          <FromUserName><![CDATA['.$postArray->ToUserName.']]></FromUserName>
          <CreateTime>'.time().'</CreateTime>
          <MsgType><![CDATA[image]]></MsgType>
          <Image>
            <MediaId><![CDATA['.$media_id.']]></MediaId>
          </Image>
        </xml>';
        //Login::info('==='.$temple);
        echo $temple;
    }


//封装图文消息的方法
function reposnimg($postArray,$array)
{
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












?>