<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/31 10:30
 *  文件描述 :  用户添加商品验证器
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\validator;
use think\Validate;

class GoodValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['goodName']  => '商品名称'
     * 输  入 : (String) $post['goodPrice'] => '商品价格'
     * 输  入 : (String) $post['goodSales'] => '商品销量'
     * 输  入 : (String) $post['goodStyle'] => '{
     *              {"styleName":"规格名称","stylePrice":"规格价格"}
     *          }'
     * 创  建 : 2018/07/31 10:33
     */
    protected $rule = [
        'goodName'  => 'require|min:1|max:20',
        'goodPrice' => 'require|number',
        'goodSales' => 'require|number',
        'goodStyle' => 'require',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/31 10:33
     */
    protected $message  =   [
        'goodName.require'  => '请输入1~20个字的商品名称',
        'goodName.min'      => '请输入1~20个字的商品名称',
        'goodName.max'      => '请输入1~20个字的商品名称',
        'goodPrice.require' => '请正确输入商品价格',
        'goodPrice.number'  => '请正确输入商品价格',
        'goodSales.require' => '请正确输入商品销量',
        'goodSales.number'  => '请正确输入商品销量',
        'goodStyle.require' => '请设置商品规格',
    ];
}