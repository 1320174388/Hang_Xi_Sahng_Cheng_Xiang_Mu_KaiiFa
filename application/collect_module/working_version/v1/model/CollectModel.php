<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CollectModel.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/01 10:18
 *  文件描述 :  个人收藏信息表
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\model;
use think\Model;

class CollectModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'collect_index';

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('v1_tableName.CollectTable');
    }
}