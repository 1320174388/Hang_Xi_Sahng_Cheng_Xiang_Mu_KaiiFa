<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  NocticeInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 15:04
 *  文件描述 :  公告信息数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\noctice_module\working_version\v1\dao;

interface NocticeInterface
{
    /**
     * 名  称 : nocticeSelect()
     * 功  能 : 获取公告信息接口声明
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'公告信息']
     * 创  建 : 2018/08/06 15:06
     */
    public function nocticeSelect();

    /**
     * 名  称 : nocticeUpdate()
     * 功  能 : 修改公告信息数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['nocticeIndex']   => '公告主键';
     * 输  入 : (String) $put['nocticeContent'] => '公告内容';
     * 输  出 : ['msg'=>'success','data'=>'公告信息']
     * 创  建 : 2018/08/06 15:06
     */
    public function nocticeUpdate($put);
}