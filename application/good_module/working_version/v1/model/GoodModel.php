<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodModel.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/31 11:11
 *  文件描述 :  商品表数据模型
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\model;
use think\Model;

class GoodModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'good_index';

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('v1_tableName.GoodTable');
    }
}