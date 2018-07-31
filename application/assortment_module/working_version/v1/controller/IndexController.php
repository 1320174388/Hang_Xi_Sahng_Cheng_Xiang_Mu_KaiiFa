<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  indexController.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/30 18:20
 *  文件描述 :  商品分类主控制器
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\controller;
use think\Controller;
use app\assortment_module\working_version\v1\service\GoodsClassService;
use app\assortment_module\working_version\v1\library\Upload;
class IndexController extends Controller
{
    /**
     * 名  称 : addGoodsClass()
     * 功  能 : 添加商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (string) $class_parent    =>  一级分类主键  【可选】
     * 输  入 : (string) $class_img_url   => 图片路径
     * 输  入 : (string) $class_name      => 分类名称
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 09:50
     */
    public function addGoodsClass()
    {
          isset($_POST['class_parent']) ? $_POST['class_parent'] : 0;
          $imgUrl = isset($_POST['class_img_url']) ? $_POST['class_img_url'] : false;
          $goodsName = isset($_POST['class_name']) ? $_POST['class_name'] : false;
          $imgUrl or exit(returnResponse(1,'请选择图片'));
          $goodsName or exit(returnResponse(1,'请输入分类名称'));
          $goods = new GoodsClassService();
          $reult = $goods->addClass($_POST);
          if ($reult['msg'] == 'success'){
              return returnResponse(0,'添加成功',true);
          }else{
              return returnResponse(1,'添加失败',false);
          }
    }
    /**
     * 名  称 : getGoodsClass()
     * 功  能 : 获取商品分类
     * 变  量 : --------------------------------------
     * 输  入 :
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 09:50
     */
    public function getGoodsClass()
    {
        $goods = new GoodsClassService();
        $data = $goods->getClass();
        return returnResponse(0,'获取成功',$data['data']);
    }
    /**
     * 名  称 : modifyGoodsClass()
     * 功  能 : 修改商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (string) $class_index     =>   分类主键
     * 输  入 : (string) $class_img_url   =>   图片路径
     * 输  入 ：(string) $class_name      =>   分类名称
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 15:10
     */
    public function modifyGoodsClass()
    {
        $class_index = isset($_POST['class_index']) ? $_POST['class_index'] : false;
        $class_name = isset($_POST['class_name']) ? $_POST['class_name'] : false;
        $class_img_url = isset($_POST['class_img_url']) ? $_POST['class_img_url'] : false;
        $class_index or exit(returnResponse(1,'没有分类主键'));
        $goodsClass = new GoodsClassService();
        $reult = $goodsClass->modifyClass($_POST);
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'修改成功',true);
        }else{
            return returnResponse(1,'修改失败',false);
        }
    }
    /**
     * 名  称 : delectGoodsClass()
     * 功  能 : 删除商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (string) $class_index     =>   分类主键
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 16:10
     */
    public function delectGoodsClass()
    {
        $class_index = isset($_GET['class_index']) ? $_GET['class_index'] : false;
        $class_index or exit(returnResponse(1,'没有分类主键'));
        $goodsClass = new GoodsClassService();
        $reult = $goodsClass->delectClass($class_index);
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'删除成功',true);
        }else{
            return returnResponse(1,'删除失败',false);
        }
    }
    /**
     * 名  称 : uploadImage()
     * 功  能 : 上传图片
     * 变  量 : --------------------------------------
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 09:20
     */
    public function uploadImage()
    {
       $upload = new Upload();
        $reult = $upload->uploadImage();
        return returnResponse(0,'请求成功',$reult);
    }
}