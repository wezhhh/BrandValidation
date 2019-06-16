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
        if(request()->post()){
            $data = input('post.');
            $con = model('Brand')->add($data);
            if($con){
                $this->returnJson('success','添加成功');
            }else{
                $this->returnJson('error','添加失败');
            }
        }else{
            $this->returnJson('error','请用post传输');
        }
    }

    //删除
    public function del(){
        if(request()->post()){
            $data = input('post.');
            $con = model('Brand')->upd($data,[
                'status' => -1
            ]);
            if($con){
                $this->returnJson('success','删除成功');
            }else{
                $this->returnJson('error','删除失败');
            }
        }else{
            $this->returnJson('error','请用post传输');
        }
    }

    //修改
    public function upd(){
        if(request()->post()){
            $data = input('post.');
//            $this->returnJson('success','数据打印',$data);
            $id = $data['id'];
            unset($data['id']);
            $con = model('Brand')->upd([
                'id'=>$id
            ],$data);
            if($con){
                $this->returnJson('success','修改成功');
            }else{
                $this->returnJson('error','修改失败');
            }
        }else{
            $this->returnJson('error','请用post传输');
        }
    }

    //列表
    public function list(){
        $data = model('Brand')->gets([
            'status'=>1
        ]);
        return $this->returnLayui($data);
    }
}