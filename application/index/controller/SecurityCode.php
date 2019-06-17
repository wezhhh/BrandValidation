<?php
/**
 * Created by PhpStorm.
 * User: xxz
 * Date: 2019/6/16
 * Time: 21:33
 * 防伪码控制器
 */

namespace app\index\controller;


class SecurityCode extends Base
{
    //防伪码页面
    public function index(){
        //查询品牌列表进行模板赋值
        $data = model('Brand')->gets([
            'status'=>1
        ],'id,name');
        $this->assign('data',$data);
        return view();
    }

    //防伪码数据
    public function list(){
        $data = model('SecurityCode')->gets();
        $data['code'] = 0;
        return json($data);
        return $this->returnLayui($data);
    }
}