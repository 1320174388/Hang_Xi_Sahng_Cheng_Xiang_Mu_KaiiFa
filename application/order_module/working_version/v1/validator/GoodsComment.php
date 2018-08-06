<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodsComment.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/06 21:18
 *  文件描述 :  商品评论数据验证器
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\validator;

use think\Validate;

class GoodsComment extends Validate
{
// +----------------------------------------------------------------------
// | 检测数据字段
// +----------------------------------------------------------------------
// | (string) `order_number`    => `订单号`
// | (string) `user_token`      => `用户标识`
// | (string) `good_index`      => `商品主键`
// | (string) `critic_content`  => `评论内容`
// | (string) `critic_name`     => `评论昵称`
// +----------------------------------------------------------------------
    protected $rule = [
        'order_number'      => 'require',
        'user_token'        => 'require',
        'good_index'        => 'require',
        'critic_content'    => 'require',
        'critic_name'       => 'require'
    ];
    protected $message = [
        'order_number.require'      => '订单号order_number不能为空',
        'user_token.require'        => '用户标识user_token不能为空',
        'good_index.require'        => '商品主键good_index不能为空',
        'critic_content.require'    => '评论内容critic_content不能为空',
        'critic_name.require'       => '评论昵称critic_name不能为空'
    ];
}