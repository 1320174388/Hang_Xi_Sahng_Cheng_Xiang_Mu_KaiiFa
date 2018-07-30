<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ReplyValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 15:12
 *  文件描述 :  添加自动回复验证器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\validator;
use think\Validate;

class ReplyValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['sessionName'] = '触发标识';
     * 输  入 : (String) $post['sessionType'] = '信息类型';
     * 输  入 : (String) $post['sessionCont'] = '回复内容';
     * 创  建 : 2018/07/24 21:20
     */
    protected $rule = [
        'sessionName' =>  'require|min:2|max:12',
        'sessionType' =>  'require',
        'sessionCont' =>  'require|max:1000',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/24 21:20
     */
    protected $message  =   [
        'sessionName.require' => '请输入2~12个字的问题',
        'sessionName.min'     => '请输入2~12个字的问题',
        'sessionName.max'     => '请输入2~12个字的问题',
        'sessionType.require' => '请发送信息状态',
        'sessionCont.require' => '请输入不超过1000字的回复内容',
        'sessionCont.max'     => '请输入不超过1000字的回复内容',
    ];
}