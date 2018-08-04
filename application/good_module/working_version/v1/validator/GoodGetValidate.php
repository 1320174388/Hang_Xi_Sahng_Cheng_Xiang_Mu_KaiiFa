<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodGetValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/04 15:23
 *  文件描述 :  查询商品数据验证器
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\validator;
use think\Validate;

class GoodGetValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $get['classIndex'] => '分类主键';
     * 输  入 : (String) $get['goodLimit']  => '商品页码';
     * 创  建 : 2018/08/04 15:38
     */
    protected $rule = [
        'classIndex' => 'require|min:32|max:32',
        'goodLimit'  => 'require|number',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/08/04 15:38
     */
    protected $message  =   [
        'classIndex.require' => '请正确输入分类标识',
        'classIndex.min'     => '请正确输入分类标识',
        'classIndex.max'     => '请正确输入分类标识',
        'goodLimit.require'  => '请正确输入商品页码',
        'goodLimit.number'   => '请正确输入商品页码',
    ];
}