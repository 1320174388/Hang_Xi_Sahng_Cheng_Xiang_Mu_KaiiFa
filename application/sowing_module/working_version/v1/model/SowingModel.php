<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SowingModel.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图模型层
 *  历史记录 :  -----------------------
 */
namespace app\sowing_module\working_version\v1\model;
use think\Model;

class SowingModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'data_sowing_lists';

    // 设置当前模型对应数据表的主键
    protected $pk = 'sowing_index';

    // 加载配置数据表名
    protected function initialize()
    {
        $this->table = config('v1_tableName.SowingLists');
    }
}
