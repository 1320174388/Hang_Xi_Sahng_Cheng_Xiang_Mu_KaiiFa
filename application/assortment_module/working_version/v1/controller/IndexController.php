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
     * 输  入 : (string) $class_parent    =>  一级分类主键    【可填】
     * 输  入 : (string) $class_img_url   => 图片路径         【必填】
     * 输  入 : (string) $class_name      => 分类名称         【必填】
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData":{}
     * 创  建 : 2018/07/31 09:50
     */
    public function addGoodsClass()
    {
          $goods = new GoodsClassService();
          //传入数据执行添加逻辑
          $reult = $goods->addClass($_POST);
          //判断执行结果
          if ($reult['msg'] == 'success'){
              //返回添加成功信息
              return returnResponse(0,'添加成功',true);
          }else{
              //返回添加失败信息
              return returnResponse(1,$reult['data'],false);
          }
    }
    /**
     * 名  称 : getGoodsClass()
     * 功  能 : 获取商品分类
     * 变  量 : --------------------------------------
     * 输  出 :{"errNum":1,"retMsg":"提示信息","retData":false
     * 输  出 :{"errNum":0,"retMsg":"提示信息","retData": {}
     * 创  建 : 2018/07/31 09:50
     */
    public function getGoodsClass()
    {
        $goods = new GoodsClassService();
        //执行获取数据
        $data = $goods->getClass();
        //数据为空返回
        if ($data['msg'] !== 'success') return returnResponse(1,'没有添加分类',$data['data']);
        //返回所有数据
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
        $goodsClass = new GoodsClassService();
        //执行修改
        $reult = $goodsClass->modifyClass($_POST);
        //执行结果
        if ($reult['msg'] == 'success'){
            //返回成功信息
            return returnResponse(0,'修改成功',true);
        }else{
            //返回失败信息
            return returnResponse(1,$reult['data'],false);
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
        //验证商品分类主键
        $class_index = isset($_GET['class_index']) ? $_GET['class_index'] : false;
        $class_index or exit(returnResponse(1,'没有分类主键'));
        //执行删除
        $goodsClass = new GoodsClassService();
        $reult = $goodsClass->delectClass($class_index);
        //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'删除成功',true);
        }else{
            return returnResponse(1,$reult['data'],false);
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