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

    //excel文件上传
    public function excel_import(){
        //上传文件
        $file = request()->file('file');

        $info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'excel');

        if($info){
//            $this->returnJson('success','上传成功',$_FILES);
            // 成功上传后 获取上传信息

            //存入绝对路径/upload/日期/文件名
            $filename = ROOT_PATH . 'public' . DS . 'excel' . DS . $info->getSaveName();

            // 输出 xls 后缀名
            $exts = $info->getExtension();

            //接下来做数据的处理
            $this->import_excel($filename,$exts);
        }else{
            // 上传失败获取错误信息
            $this->returnJson('error',$file->getError());
        }
    }

    //excel文件读取数据
    public function import_excel($filename,$exts = 'xls'){
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();

        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            $PHPReader = new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();

        $data = [];
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for($currentRow=2;$currentRow <= $allRow;$currentRow++){
            //从那列开始，A表示第一列
            for ($currentColumn='A';$currentColumn <= $allColumn;$currentColumn++){
                //数据坐标
                $address = $currentColumn . $currentRow;

                //读取到的数据，保存到数组$DATA中
                $cell = $currentSheet->getCell($address)->getValue();

                if($cell instanceof \PHPExcel_RichText){
                    $cell = $cell->__toString();
                }
                $data[$currentRow -1][$currentColumn] = $cell;
            }
        }
        //如果excel表格没有数据
        if(empty($data)){
            $this->returnJson('error','将上传有数据的excel表格');
        }
        $this->insert_data($data);
    }

    //将excel数据添加到数据库中
    public function insert_data($data){
        $arr = [];
        $time = time();
        $success_count = 0;
        $error_count = 0;
        foreach ($data as $k=>$v) {
            $code = model('SecurityCode')->info([
                'security_code'=>$v['A']
            ],'id');
            if($code){
                $error_count++;
            }else{
                $arr[] = [
                    'security_code'=>$v['A'],
                    'brand_id'=>$v['B'],
                    'cooperator_id'=>$v['C'],
                    'time'=>$time
                ];
                $success_count++;
            }
        }
        //批量添加防伪码数据
        $con = model('SecurityCode')->add($arr,true);
        if($con){
            $this->returnJson('success','成功导入数据'.$success_count.'条 , 导入失败'.$error_count.'条,失败原因：此数据已存在于数据库');
        }else{
            $this->returnJson('error','导入失败');
        }
    }
}