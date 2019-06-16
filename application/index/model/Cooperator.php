<?php
/**
 * Created by PhpStorm.
 * User: xxz
 * Date: 2019/6/16
 * Time: 19:19
 * 重点合作品牌表
 */

namespace app\index\model;


use think\Db;
use think\Model;

class Cooperator extends Model
{
    //添加
    public function add($data=[]){
        $data['time'] = time();
        return $this->allowField(true)->save($data);
    }

    public function info($where=[],$field='*'){
        return $this->where($where)->field($field)->find();
    }

    //获取所有重点品牌
    public function gets($where=[],$field='*'){
        return Db::view('Cooperator',$field)
            ->view('Brand',['name'=>'brand_name'],'Cooperator.brand_id = Brand.id')
            ->where($where)
            ->select();
    }

    //修改
    public  function upd($where=[],$data=[]){
        return $this->where($where)->update($data);
    }
}