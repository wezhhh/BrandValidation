<?php
/**
 * Created by PhpStorm.
 * User: xxz
 * Date: 2019/6/16
 * Time: 17:19
 * 重点合作商
 */

namespace app\index\controller;


class Cooperator extends Base
{
    //重点合作商页面
    public function index(){
        //查询品牌列表进行模板赋值
        $data = model('Brand')->gets([
            'status'=>1
        ],'id,name');
        $this->assign('data',$data);
        return view();
    }

    //添加页面
    public function add_view(){
        //查询品牌列表进行模板赋值
        $data = model('Brand')->gets([
            'status'=>1
        ],'id,name');
        $this->assign('data',$data);
        return view();
    }

    //列表数据
    public function list(){
        $data = model('Cooperator')->gets([
            'Cooperator.status'=>1
        ]);
        return $this->returnLayui($data);
    }

    //添加
    public function add(){
        if(request()->post()){
            $data = input('post.');
            $con = model('Cooperator')->add($data);
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
            $con = model('Cooperator')->upd($data,[
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
            $id = $data['id'];
            unset($data['id']);
            $con = model('Cooperator')->upd([
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
}