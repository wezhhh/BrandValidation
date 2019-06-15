<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/14
 * Time: 18:01
 * 防伪码品牌
 */

namespace app\index\controller;

class Brand extends Base
{
    //品牌页面
    public function index(){
        return view();
    }

    //品牌添加页面
    public function add_view(){
        return view();
    }

    //品牌添加
    public function add(){
        $data = input('post.');
        $con = model('Brand')->add($data);
        if($con){
            $this->returnJson('success','添加成功');
        }else{
            $this->returnJson('success','添加失败');
        }
    }

    //列表
    public function list(){
        $data = model('Brand')->gets();
        return $this->returnLayui($data);
    }
}