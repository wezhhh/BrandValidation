<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/18
 * Time: 10:35
 * 防伪码api验证
 */

namespace app\index\controller;

use think\Db;

class Api extends Base
{
    //防伪码验证  site网页123   code防伪码  brand_id 品牌id
    public function verification($site=0,$code='',$brand_id=0){
        if(!empty($code)){
            $data = model('SecurityCode')->info([
                'security_code'=>$code,
                'brand_id'=>$brand_id
            ]);
            if($data){
                Db::name('SecurityCode')->where(['security_code'=>$code])->setInc('count');
                //没有验证过
                if($data['count'] == 0){
                    model('SecurityCode')->upd([
                        'security_code'=>$code
                    ],[
                        'query_time'=>time()
                    ]);
                    $arr['count'] = 0;
//                    $this->returnJson('success','您查询的产品为<b>第1次</b>验证');
                }else{
                    $arr['count'] = $data['count']+1;
                    $arr['time'] = date('Y-m-d H:i:s',$data['query_time']);
//                    $this->returnJson('success','您查询的产品为<b>第'.($data['count']+1).'次验证');
                }
            }

            //brand_id  1德国艾仕壁纸 2 DENO 德诺壁纸软装 3 HARVEST 臻仕家居
            //如果为臻仕页面 且当前防伪码属于蓝色情人
            if($site == 1 && $data['cooperator_id'] == 4){
                $class = 2;
            }else if($site == 1 &&  $data['cooperator_id'] == 5){
                //属于费雷
                $class = 3;
            }else if($site == 1){
                //只属于臻仕
                $class = 1;
            }else if($site == 2 && $data['cooperator_id'] == 1){
                //如果为艾仕页面 且当前防伪码属于范思哲
                $class = 2;
            }else if($site == 2){
                //只属于艾仕
                $class = 1;
            }else if($site == 3 && $data['cooperator_id'] == 2){
                //如果为德诺页面 且当前防伪码属于兰博基尼
                $class = 2;
            }else if($site == 3 && $data['cooperator_id'] == 3){
                //如果为德诺页面 且当前防伪码属于可口可乐
                $class = 3;
            }else if($site == 3){
                $class = 1;
            }else{
                $this->returnJson('success','404');
            }
            $arr['code'] = $code;
            $this->assign('data',$arr);
            return view('index/site'.$site.'_class'.$class);
        }else{
            $this->returnJson('error','请输入防伪码');
        }
    }
}