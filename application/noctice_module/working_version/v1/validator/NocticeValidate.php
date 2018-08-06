<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  NocticeValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 14:35
 *  文件描述 :  公告信息逻辑处理
 *  历史记录 :  -----------------------
 */
namespace app\noctice_module\working_version\v1\validator;
use think\Validate;

class NocticeValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $put['nocticeIndex']   => '公告主键';
     * 输  入 : (String) $put['nocticeContent'] => '公告内容';
     * 创  建 : 2018/08/06 14:35
     */
    protected $rule = [
        'nocticeIndex'   => 'require|min:32|max:32',
        'nocticeContent' => 'require|max:200',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/31 10:33
     */
    protected $message  =   [
        'nocticeIndex.require'   => '请正确发送公告主键',
        'nocticeIndex.min'       => '请正确发送公告主键',
        'nocticeIndex.max'       => '请正确发送公告主键',
        'nocticeContent.require' => '请输入1~200字的公告信息',
        'nocticeContent.max'     => '请输入1~200字的公告信息',
    ];
}