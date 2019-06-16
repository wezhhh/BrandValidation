<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/15
 * Time: 17:37
 */

namespace app\index\controller;

use think\File;
class Upload extends Base
{
    //图片上传
    public function upload_img(){
        //获取上传的文件
        $file = request()->file('file');
            //将文件移动到框架应用根目录/public/static/images/目录下
            $img_url =  DS.'static'.DS.'images';
            $info = $file->move(ROOT_PATH.'public'.$img_url);
            if($info){
                //存入相对路径
                $data = $img_url.DS.$info->getSaveName();
                $this->returnJson('success','上传成功',['url'=>$data]);
            }else{
                $this->returnJson('error','上传失败');
            }
    }

    //excel导入
    public function excel_import(){
        //上传文件
        $file = request()->file('file');

        $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'excel');

        if($info){
            $this->returnJson('success','上传成功',$_FILES);
            // 成功上传后 获取上传信息

            //存入绝对路径/upload/日期/文件名
            $filename = ROOT_PATH . 'public' . DS . 'excel' . DS . $info->getSaveName();

            // 输出 xls 后缀名
            $exts = $info->getExtension();


            //接下来做数据的处理
        }else{
            // 上传失败获取错误信息
            $this->returnJson('error',$file->getError());
        }
    }
}