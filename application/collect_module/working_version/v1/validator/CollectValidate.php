<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CollectValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/01 10:08
 *  文件描述 :  个人收藏商品验证器
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\validator;
use think\Validate;

class CollectValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 创  建 : 2018/08/01 10:08
     */
    protected $rule = [
        'userToken' => 'require|min:32|max:32',
        'goodIndex' => 'require|min:32|max:32',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/08/01 10:08
     */
    protected $message  =   [
        'userToken.require'=> '请正确发送用户标识',
        'userToken.min'    => '请正确发送用户标识',
        'userToken.max'    => '请正确发送用户标识',
        'goodIndex.require'=> '请正确发送商品标识',
        'goodIndex.min'    => '请正确发送商品标识',
        'goodIndex.max'    => '请正确发送商品标识',
    ];
}