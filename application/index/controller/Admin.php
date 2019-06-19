<?php
namespace app\index\controller;


class Admin extends Base
{
    public function index($pass='')
    {
        if($pass == 'admin'){
            return view();
        }
     }
}
