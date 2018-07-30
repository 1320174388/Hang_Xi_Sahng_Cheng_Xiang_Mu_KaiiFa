<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ProblemValidate.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/25 14:59
 *  文件描述 :  添加提问信息验证器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\validator;
use think\Validate;

class ProblemValidate extends Validate
{
    /**
     * 名  称 : $rule => '静态属性'
     * 功  能 : 定义验证规则
     * 输  入 : (String) $post['peopleIndex']  = '用户身份标识';
     * 输  入 : (String) $post['peopleName']   = '用户名称';
     * 输  入 : (String) $post['peopleSex']    = '用户性别';
     * 输  入 : (String) $post['leavingTitle'] = '问题标题';
     * 输  入 : (String) $post['messageCont']  = '问题内容';
     * 创  建 : 2018/07/24 21:20
     */
    protected $rule = [
        'peopleIndex'  => 'require|min:32|max:32',
        'peopleFormid' => 'require',
        'peopleName'   => 'require',
        'peopleSex'    => 'require|min:1|max:1',
        'leavingTitle' => 'require|min:2|max:12',
        'messageCont'  => 'require|max:1000',
    ];
    /**
     * 名  称 : $message => '静态属性'
     * 功  能 : 定义错误返回信息
     * 创  建 : 2018/07/24 21:20
     */
    protected $message  =   [
        'peopleIndex.require'  => '请正确发送用户身份标识',
        'peopleIndex.min'      => '请正确发送用户身份标识',
        'peopleIndex.max'      => '请正确发送用户身份标识',
        'peopleFormid.require' => '请发送用户表单FormId',
        'peopleName.require'   => '请发送用户名称',
        'peopleSex.require'    => '请正确发送用户性别信息',
        'peopleSex.min'        => '请正确发送用户性别信息',
        'peopleSex.max'        => '请正确发送用户性别信息',
        'leavingTitle.require' => '请输入2~12个字的问题',
        'leavingTitle.min'     => '请输入2~12个字的问题',
        'leavingTitle.max'     => '请输入2~12个字的问题',
        'messageCont.require'  => '请输入不超过1000字的问题内容',
        'messageCont.max'      => '请输入不超过1000字的问题内容',
    ];
}