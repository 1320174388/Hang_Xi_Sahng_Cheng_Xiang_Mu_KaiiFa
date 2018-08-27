<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderDataCheck.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/04 09:18
 *  文件描述 :  订单数据验证器
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\validator;

use think\Validate;

class OrderDataCheck extends Validate
{
// +----------------------------------------------------------------------
// | 检测数据字段
// +----------------------------------------------------------------------
// | (string) `order_number`    => `订单号`
// | (string) `user_token`      => `用户标识`
// | (string) `order_people`    => `收件人名称`
// | (string) `order_phone`     => `收件人电话`
// | (string) `order_address`   => `收件人地址`
// | (string) `order_formd`     => `表单提交ID`
// | (string) `good_prices`     => `商品总价格`
// | (int)    `order_gdnu`      => `商品数量`
// | (string) `order_group`     => `商品信息`
// +----------------------------------------------------------------------

    protected $rule = [
        'order_number'  => 'require|min:24|max:24',
        'user_token'    => 'require|min:32|max:32',
        'order_people'  => 'require',
        'order_phone'   => 'require',
        'order_address' => 'require',
        'order_formd'   => 'require',
        'good_prices'   => 'require',
        'order_gdnu'    => 'require',
        'order_group'   => 'require'
    ];
    protected $message =[
        'order_number.require'  => '订单号order_number不能为空',
        'order_number.min'      => '订单号order_number错误应为24位',
        'order_number.max'      => '订单号order_number错误应为24位',
        'user_token.require'    => '用户token不能为空',
        'user_token.min'        => '用户token错误',
        'user_token.max'        => '用户token错误',
        'order_people.require'  => '收件人名称order_people不能为空',
        'order_phone.require'   => '收件人电话order_phone不能为空',
        'order_address.require' => '收件人地址order_address不能为空',
        'order_formd.require'   => '表单提交IDorder_formd不能为空',
        'good_prices.require'   => '商品总价格good_prices不能为空',
        'order_gdnu.require'    => '商品数量order_gdnu不能为空',
        'order_group.require'   => '商品信息order_group不能为空'
    ];
}