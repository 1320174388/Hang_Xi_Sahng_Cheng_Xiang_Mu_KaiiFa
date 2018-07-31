<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  UploadImage.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/31 09:20
 *  文件描述 :  上传图片
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\library;
class Upload
{
    /**
     * 名  称 : uploadImage()
     * 功  能 : 上传图片
     * 变  量 : --------------------------------------
     * 输  入 :
     * 输  出 :
     * 创  建 : 2018/07/31 09:20
     */
    public function uploadImage()
    {
        //创建图片目录
        $dir = './uploads/class';
        is_dir($dir) or mkdir($dir,0777,true);
        //判断图片大小
        if ($_FILES['images']['size'] <= 1024*1024*2){
            //获取图片后缀
            $imgType = $_FILES['images']['type'];
            $_img = substr($imgType,strcspn($imgType,'/')+1);
            //图片重命名
            $imgName = ''.time().''.randomInt().'.'.$_img;
            //移动到文件夹
            $res = move_uploaded_file($_FILES['images']['tmp_name'], './uploads/class/'.$imgName);
            if ($res){
                return 'uploads/class/'.$imgName;
            }else{
                return '失败';
            }
        }else {
            return '图片大于2m';
        }
    }
}