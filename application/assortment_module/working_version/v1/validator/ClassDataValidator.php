<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ClassDataValidator.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/01 10:19
 *  文件描述 :  商品分类数据验证
 *  历史记录 :  -----------------------
 */
namespace app\assortment_module\working_version\v1\validator;
use think\Validate;
class ClassDataValidator extends Validate
{
    protected $rule = [
        'class_name'    => 'require',
        'class_img_url' => 'require',
        'class_index'   => 'require'
    ];
    protected $message = [
        'class_name.require'    => '缺少分类名称',
        'class_img_url.require' => '缺少图片路径',
        'class_index.require'   => '缺少分类主键'
    ];
}