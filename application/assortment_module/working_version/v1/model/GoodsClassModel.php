<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodsClass.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/30 18:59
 *  文件描述 :  商品分类表模型
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\model;
use think\Model;
class GoodsClassModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'class_index';

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('tableName.GoodsClass');
    }
}