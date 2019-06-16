<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/15
 * Time: 10:28
 * 品牌表
 */
namespace app\index\model;
class Brand extends \think\Model
{
    //添加品牌
    public function add($data=[]){
        $data['time'] = time();
        return $this->allowField(true)->save($data);
    }

    public function info($where=[],$field='*'){
        return $this->where($where)->field($field)->find();
    }

    //获取所有品牌
    public function gets($where=[],$field='*'){
        return $this->where($where)->field($field)->select();
    }

    //修改
    public  function upd($where=[],$data=[]){
        return $this->where($where)->update($data);
    }
}