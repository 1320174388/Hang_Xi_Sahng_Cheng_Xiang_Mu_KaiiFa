<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderMain.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 10:18
 *  文件描述 :  订单信息数据模型
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\model;
use think\Model;
class OrderMain extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'order_number';

    //设置时间字段名称
    protected $createTime = 'order_time';

    //开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('tableName.OrderMain');
    }
    //关联订单详情表
    public function details()
    {
       return $this->hasMany('OrderDetails','order_number');
    }
}