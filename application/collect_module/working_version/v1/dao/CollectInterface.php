<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CollectInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/01 10:13
 *  文件描述 :  个人收藏接口声明
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\dao;

interface CollectInterface
{
    /**
     * 名  称 : collectCreate()
     * 功  能 : 添加个人收藏信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/08/01 10:14
     */
    public function collectCreate($post);

    /**
     * 名  称 : collectGoodSelect()
     * 功  能 : 获取个人收藏商品数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['userToken'] => '用户标识';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/08/01 11:35
     */
    public function collectGoodSelect($get);

    /**
     * 名  称 : collectSelect()
     * 功  能 : 获取收藏信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/08/01 10:53
     */
    public function collectSelect($get);
}