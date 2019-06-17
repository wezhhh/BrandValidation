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
        return view();
    }

    //防伪码数据
    public function list($page=1,$limit=10){
        //配置分页
        $arr['page'] = ($page-1)*$limit;
        $arr['limit'] = $limit;
        $data = model('SecurityCode')->gets([],'*',$arr);
        $count = model('SecurityCode')->get_count();
        return $this->returnLayui($count,$data);
    }
}