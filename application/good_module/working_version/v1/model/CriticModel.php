<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CriticModel.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/02 10:58
 *  文件描述 :  商品评论信息表
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\model;
use think\Model;

class CriticModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'id';

    //设置时间字段名称
    protected $createTime = 'critic_time';

    //开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('v1_tableName.CriticTable');
    }
}