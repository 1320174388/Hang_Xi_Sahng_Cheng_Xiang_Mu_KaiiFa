<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SessionValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/26 16:44
 *  文件描述 :  继续提问信息验证器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\validator;
use think\Validate;

class SessionValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 创  建 : 2018/07/24 21:20
     */
    protected $rule = [
        'leavingIndex' => 'require|min:32|max:32',
        'messageCont'  => 'require|max:1000',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/24 21:20
     */
    protected $message  =   [
        'leavingIndex.require' => '请正确发送问题标识',
        'leavingIndex.min'     => '请正确发送问题标识',
        'leavingIndex.max'     => '请正确发送问题标识',
        'messageCont.require'  => '请输入不超过1000字的回复内容',
        'messageCont.max'      => '请输入不超过1000字的回复内容',
    ];
}