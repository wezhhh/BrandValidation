<?php
namespace app\index\controller;
use think\Controller;

use think\Log;
use think\Cache;
use think\Config;
use think\Db;
use think\Debug;
use think\Request;
use think\Response;

// Base
class Base extends Controller
{
    //debug信息输出
    private function debug_out(){
        // 获取基本信息
        $runtime = number_format(microtime(true) - THINK_START_TIME, 10);
        $reqs    = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
        $mem     = number_format((memory_get_usage() - THINK_START_MEM) / 1024, 2);
        if (isset($_SERVER['HTTP_HOST'])) {
            $uri = $_SERVER['SERVER_PROTOCOL'] . ' ' . $_SERVER['REQUEST_METHOD'] . ' : ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $uri = 'cmd:' . implode(' ', $_SERVER['argv']);
        }
        $base = [
            '请求信息' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . ' ' . $uri,
            '运行时间' => number_format($runtime, 6) . 's [ 吞吐率：' . $reqs . 'req/s ] 内存消耗：' . $mem . 'kb 文件加载：' . count(get_included_files()),
            '查询信息' => Db::$queryTimes . ' queries ' . Db::$executeTimes . ' writes ',
            '缓存信息' => Cache::$readTimes . ' reads,' . Cache::$writeTimes . ' writes',
            '配置加载' => count(Config::get()),
        ];
        return [
            'base'=>$base,
            // 'error'=>Log::getLog()
        ];
    }
    //统一输出json
    public function returnJson($status='',$msg='',$data=[],$powers=[]){
        $json = [
            'code'=>($status=='success')?200:(is_numeric($status)?$status:201)
        ];
        if($msg){
            $json['msg'] = $msg;
        }
        if($data){
            $json['data'] = $data;
        }
        $json['powers'] = $powers;
        
        if(config('app_trace')){
            $json['debug'] = $this->debug_out();
        }
        exit(json_encode($json,JSON_UNESCAPED_UNICODE));
    }

    //Layui表格统一返回
    public function returnLayui($data=[]){
        return json([
            'code'=>0,
            'data'=>$data
        ]);
    }
}