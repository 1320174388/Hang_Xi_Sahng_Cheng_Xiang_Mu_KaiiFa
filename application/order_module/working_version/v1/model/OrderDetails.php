<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderDetails.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 10:18
 *  文件描述 :  订单详细信息数据模型
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\model;
use think\Model;
class OrderDetails extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 加载配置数据表名
    public function initialize()
    {
        $this->table = config('tableName.OrderDetails');
    }
}