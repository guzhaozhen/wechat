<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Media;
class deleteMaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteMaterial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '素材管理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = time();
       $pageSize = config('app.pageSize');
        $mediaInfo = Media::join('type','media.t_id','=','type.t_id')
            ->Orderby('m_id','desc')->paginate($pageSize);
        $ids = $urls = [];
        foreach($mediaInfo as $key=>$value){
            if($time-$value->addtime>3*24*60*60){
                $urls[$key] = $value->m_img;
                $ids[$key] = $value->m_id;
            }
        }
       // dd($ids);
      //  文件删除 (阿里云 如果是永久素材记得删除微信服务器的)
        foreach($urls as $v){
            $path = storage_path('app/'.$v);
            if(file_exists($path)){
                unlink($path);
            }
        }
       // 删除
        $res = Media::destory($ids);
        if($res){
            Log::info('删除素材成功主键ID为:'.implode(','.$ids));
        }

        Log::info('这是一个测试');
    }
}
