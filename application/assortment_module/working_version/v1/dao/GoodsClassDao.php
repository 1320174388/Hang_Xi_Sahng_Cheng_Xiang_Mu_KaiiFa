<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodsClassDao.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/30 20:00
 *  文件描述 :  商品分类数据操作
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\dao;
use app\assortment_module\working_version\v1\model\GoodsClassModel;
class GoodsClassDao
{
    /**
     * 名  称 : add()
     * 功  能 : 添加商品分类
     * 变  量 : --------------------------------------
     * 输  入 ：(array) $classData => 分类数据
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 输  出 : [ 'msg' => 'error', 'data' => '' ]
     * 创  建 : 2018/07/31 09:50
     */
    public function add($classData)
    {
        $goods = new GoodsClassModel();
        //判断分类名称是否重复
        $isName =$goods->where('class_name', $classData['class_name'])
              ->field('class_name')->find();
        //已存在名称提示信息
        if ($isName) return returnData('error','分类名称已存在');
        //执行添加
        $data = $goods->allowField(true)->save($classData);
        return returnData('success',$data);
    }
    /**
     * 名  称 : queryOne()
     * 功  能 : 查询单条商品分类
     * 变  量 : --------------------------------------
     * 输  入 ：(string) $class_index  => 分类主键
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 09:50
     */
    public function queryOne($class_index)
    {
        $goods = new GoodsClassModel();
        $data = $goods->where('class_index',$class_index)->find();
        return returnData('success',$data);
    }
    /**
     * 名  称 : queryOne()
     * 功  能 :  以父类主键查询子类商品分类
     * 变  量 : --------------------------------------
     * 输  入 ：(string) $class_index  => 分类主键
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 09:50
     */
    public function sonQuery($class_index)
    {
        //查询子分类
       $reult = (new GoodsClassModel())->where('class_parent',$class_index)->find();
       //查询结果
       if($reult){
           //查询成功
           return returnData('success',true);
       }else{
           //查询失败
           return returnData('error',false);
       }
    }
    /**
     * 名  称 : query()
     * 功  能 : 查询商品分类
     * 变  量 : --------------------------------------
     * 输  出 ：[ 'msg' => 'error', 'data' => $data ]
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 09:50
     */
    public function query()
    {
        //执行模型查询
        $data = GoodsClassModel::all();
        //返回 错误信息
        if(!$data) return returnData('error',$data);
        //返回 数据
       return returnData('success',$data);
    }

    /**
     * 名  称 : modify()
     * 功  能 : 修改商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (array)   $data  =>  商品分类数据
     * 输  出 :[ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 15:10
     */
    public function modify($data)
    {
        $model = new GoodsClassModel();
       $reult = $model->where('class_index',$data['class_index'])->update($data);
       return returnData('success',$reult);
    }
    /**
     * 名  称 : delect()
     * 功  能 : 删除商品分类
     * 变  量 : --------------------------------------
     * 输  入 : (string)  $class_index  =>   商品主键
     * 输  出 :[ 'msg' => 'success', 'data' => $data ]
     * 创  建 : 2018/07/31 15:10
     */
    public function delect($class_index)
    {
        $goodsClass = new GoodsClassModel();
        $reult = $goodsClass->where('class_index',$class_index)->delete();
        return returnData('success',$reult);
    }
}
