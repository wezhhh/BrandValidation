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
    //防伪码验证
    public function verification($code=''){
        if(!empty($code)){
            $data = model('SecurityCode')->info([
                'security_code'=>$code
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
                }else{
                    $arr['count'] = $data['count']+1;
                    $arr['time'] = date('Y-m-d H:i:s',$data['query_time']);
                }
            }else{
//                $this->returnJson('error','没有此防伪码,请核对您输入的防伪码是否和商品上的防伪码一致,如果一致则可能为假货。');
            }
            $arr['code'] = $code;
            $this->assign('data',$arr);
            return view('index/site1_class1');
        }else{
            $this->returnJson('error','请输入防伪码');
        }
    }
}