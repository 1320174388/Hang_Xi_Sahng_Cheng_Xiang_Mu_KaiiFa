<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodsClassService.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/31 10:19
 *  文件描述 :  商品分类逻辑
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\service;
use app\assortment_module\working_version\v1\dao\GoodsClassDao;
class GoodsClassService
{
    /**
     * 名  称 : addClass()
     * 功  能 : 添加商品分类
     * 变  量 : --------------------------------------
     * 输  入 ：(array) $classData => 分类数据
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 输  出 : [ 'msg' => 'error',  'data' => $data ]
     * 创  建 : 2018/07/31 09:50
     */
    public function addClass($classData)
    {

        $data = new GoodsClassDao();
        $classData['class_index'] = md5(uniqid() . mt_rand(1, 999999999));
        $reult = $data->add($classData);
        if ($reult['data']) {
            return returnData('success', $reult['data']);
        } else {
            return returnData('error', $reult['data']);
        }
    }
    /**
     * 名  称 : getClass()
     * 功  能 : 获取商品分类
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 09:50
     */
    public function getClass()
    {
        $D = (new GoodsClassDao())->query();
        if($D['msg']=='error')
            return returnData('error',$D['data']);
        $masterClass = [];
        foreach($D['data'] as $k=>$v){
            if($v['class_parent']==0){
                $masterClass[] = $v->toArray();
            }
        }
        foreach($masterClass as $k=>$v){
            $masterClass[$k]['son_class'] = [];
            foreach($D['data'] as $i=>$j){
                if($v['class_index']==$j['class_parent']){
                    $masterClass[$k]['son_class'][] = $j;
                }
            }
        }
        return returnData('success',$masterClass);
    }
    /**
     * 名  称 : modifyClass()
     * 功  能 : 修改商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (array)  $data   =>  商品分类数据
     * 输  出 :[ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 15:10
     */
    public function modifyClass($data)
    {
        $classDao = new GoodsClassDao();
        $goodsData = $classDao->queryOne($data['class_index']);
        //判断如果图片被修改删除原图片
        if($data['class_img_url'] !== $goodsData['data']['class_img_url'])
        {
            unlink($goodsData['data']['class_img_url']);
        }
       $reult = $classDao->modify($data);
        if ($reult['data']) {
            return returnData('success', $reult['data']);
        } else {
            return returnData('error', $reult['data']);
        }
    }
    /**
     * 名  称 : delectClass()
     * 功  能 : 删除商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (array)  $class_index   =>  商品分类主键
     * 输  出 :[ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 16:10
     */
    public function delectClass($class_index)
    {
        $goodsClass = new GoodsClassDao();
        $goodsData = $goodsClass->queryOne($class_index);
        $reult = $goodsClass->delect($class_index);
        if ($reult['data']) {
            //删除图片资源
            @unlink($goodsData['data']['class_img_url']);
            return returnData('success', $reult['data']);

        } else {
            return returnData('error', $reult['data']);
        }
    }
}