<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 18:01
 * 防伪码品牌
 */

namespace app\index\controller;


use think\Collection;

class CodeType extends Collection
{
    //品牌页面
    public function index(){
        return view();
    }

    //品牌添加页面
    public function add_view(){
        return view();
    }
}