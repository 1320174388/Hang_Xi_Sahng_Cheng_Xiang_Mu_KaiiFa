<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SowingInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图_数据接口声明
 *  历史记录 :  -----------------------
 */
namespace app\sowing_module\working_version\v1\dao;

interface SowingInterface
{
    /**
     * 名  称 : sowingSelect()
     * 功  能 : 声明:获取轮播图列表数据处理
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/25 17:06
     */
    public function sowingSelect($get);

    /**
     * 名  称 : sowingCreate()
     * 功  能 : 声明:添加轮播图数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $post['sowingFile']  => '轮播图文件资源';
     * 输  入 : $post['sowingSort']  => '轮播图排序数字';
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/25 14:47
     */
    public function sowingCreate($post);
}
