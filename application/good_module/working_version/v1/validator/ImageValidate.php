<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ImageValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/31 17:03
 *  文件描述 :  添加商品图片接口
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\validator;
use think\Validate;

class ImageValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['goodIndex'] = '商品主键';
     * 输  入 : (String) $post['imageType'] = '图片类信';  master / son
     * 输  入 : (String) $post['imageSort'] = '图片排序';
     * 创  建 : 2018/07/31 10:33
     */
    protected $rule = [
        'goodIndex' => 'require|min:32|max:32',
        'imageType' => 'require',
        'imageSort' => 'require|number',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/31 10:33
     */
    protected $message  =   [
        'goodIndex.require' => '请正确发送商品主键',
        'goodIndex.min'     => '请正确发送商品主键',
        'goodIndex.max'     => '请正确发送商品主键',
        'imageType.require' => '请发送图片类型',
        'imageSort.require' => '请正确输入商品排序',
        'imageSort.number'  => '请正确输入商品排序',
    ];
}