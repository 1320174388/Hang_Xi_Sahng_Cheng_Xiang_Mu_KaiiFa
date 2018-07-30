<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ReplyInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/24 21:52
 *  文件描述 :  自动回复数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\dao;

interface ReplyInterface
{
    /**
     * 名  称 : replyCreate()
     * 功  能 : 添加自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['sessionName'] = '触发标识';
     * 输  入 : (String) $post['sessionType'] = '信息类型';
     * 输  入 : (String) $post['sessionCont'] = '回复内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 21:54
     */
    public function replyCreate($post);

    /**
     * 名  称 : replySelect()
     * 功  能 : 获取自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:02
     */
    public function replySelect();

    /**
     * 名  称 : replyUpdate()
     * 功  能 : 修改自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['sessionIndex'] = '信息主键';
     * 输  入 : (String) $put['sessionName']  = '触发标识';
     * 输  入 : (String) $put['sessionType']  = '信息类型';
     * 输  入 : (String) $put['sessionCont']  = '回复内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:36
     */
    public function replyUpdate($put);

    /**
     * 名  称 : replyDelete()
     * 功  能 : 删除自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['sessionIndex'] = '信息主键';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:36
     */
    public function replyDelete($delete);
}