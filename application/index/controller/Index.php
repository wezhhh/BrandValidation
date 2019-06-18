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
    //进入页面
    public function index($site=0){
        if($site != 0){
            return view('index/site'.$site);
        }
    }
}