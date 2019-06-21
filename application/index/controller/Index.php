<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/18
 * Time: 10:09
 * 前端页面控制器
 */

namespace app\index\controller;


use think\Collection;

class Index extends Collection
{
    //进入页面   页面  1 至臻  2 艾仕  3德诺
    public function index($site=0){
        if($site != 0){
            $arr = [1,2,3];
            //如果不为三个 则默认跳 艾仕
            if(!in_array($site,$arr)){
                $site = 2;
            }
            return view('index/site'.$site);
        }
    }
}