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
use app\assortment_module\working_version\v1\validator\ClassDataValidator;
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
        //生成商品分类主键id
        $classData['class_index'] = md5(uniqid() . mt_rand(1, 999999999));
        //验证商品分类数据
        $dataCheck = new ClassDataValidator();
        if(!$dataCheck->check($classData)){
            //返回验证错误信息
            return returnData('error', $dataCheck->getError());
        }
        //执行添加
        $data = new GoodsClassDao();
        $reult = $data->add($classData);
        //执行添加结果
        if ($reult['msg'] == 'success') {
            //返回添加成功信息
            return returnData('success', $reult['data']);
        } else {
            //返回添加失败信息
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
        //执行获取数据
        $D = (new GoodsClassDao())->query();
        //返回数据为空
        if($D['msg']=='error') return returnData('error',$D['data']);
        $masterClass = [];
        //提取主分类
        foreach($D['data'] as $k=>$v){
            if($v['class_parent']==0){
                $masterClass[] = $v->toArray();
            }
        }
        //商品分类转化成二维数组
        foreach($masterClass as $k=>$v){
            $masterClass[$k]['son_class'] = [];
            foreach($D['data'] as $i=>$j){
                if($v['class_index']==$j['class_parent']){
                    $masterClass[$k]['son_class'][] = $j;
                }
            }
        }
        //返回商品分类数据
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
        //验证分类信息数据
        $dataCheck = new ClassDataValidator();
        if (!$dataCheck->check($data))
        {
            return returnData('error', $dataCheck->getError());
        }
        //判断如果图片被修改删除原图片
        $goodsData = $classDao->queryOne($data['class_index']);
        if($data['class_img_url'] !== $goodsData['data']['class_img_url'])
        {
            @unlink($goodsData['data']['class_img_url']);
        }
        //执行修改操作
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
        //查询子分类
        $sonClass = $goodsClass->sonQuery($class_index);
        if ($sonClass['msg'] == 'success'){
            return returnData('error','这个分类下有子分类不可删除');
        }
        //查询图片路径
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