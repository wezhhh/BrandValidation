<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/17
 * Time: 16:10
 * 防伪码表
 */

namespace app\index\model;


use think\Db;
use think\Model;

class SecurityCode extends Model
{
    //防伪码添加
    public function add($data=[],$all=false){
        if($all){
            return $this->saveAll($data);
        }
        return $this->allowField(true)->save($data);
    }

    //防伪码详情
    public function info($where=[],$field='*'){
        return $this->where($where)->field($field)->find();
    }

    //获取所有防伪码信息
    public function gets($where=[],$field='*',$limit=[]){
        $data = Db::view('SecurityCode',$field)
            ->view('Brand',['name'=>'brand_name'],'SecurityCode.brand_id = Brand.id')
            ->where($where)
            ->limit($limit['page'],$limit['limit'])
            ->select();
        if(!empty($data)){
            foreach ($data as $item){
                //查询当前防伪码是否属于重点合作商
                $id = \model('Cooperator')->info([
                    'id'=>$item['cooperator_id']
                ],'id,name');
                $item['cooperator_name'] = $item['id'] == 0 ? '无':$id['name'];
            }
        }
        return $data;
    }

    //获取所有防伪码数量
    public function get_count($where=[],$field='*'){
        return Db::view('SecurityCode',$field)
            ->view('Brand',['name'=>'brand_name'],'SecurityCode.brand_id = Brand.id')
            ->where($where)
            ->count();
    }
}