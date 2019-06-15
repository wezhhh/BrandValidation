<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::rule('/index/index','/index/Index/index');
Route::rule('/brand/index','/index/Brand/index');
Route::rule('/brand/add_view','/index/Brand/add_view');
Route::rule('/brand/list','/index/Brand/list');
Route::rule('/upload/upload_img','/index/Upload/upload_img');
//Route::rule('codetype/add_view/','index/codetype/add_view/');
