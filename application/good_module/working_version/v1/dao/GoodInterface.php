<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodInterface.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/21 10:52
 *  文件描述 :  商品数据声明接口
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\dao;

interface GoodInterface
{
    /**
     * 名  称 : goodCreate()
     * 功  能 : 添加商品信息到数据库
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodName']  => '商品名称'
     * 输  入 : (String) $post['goodPrice'] => '商品价格'
     * 输  入 : (String) $post['goodSales'] => '商品销量'
     * 输  入 : (String) $post['goodStyle'] => '{
     *              {"styleName":"规格名称","stylePrice":"规格价格"}
     *          }'
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 10:11
     */
    public function goodCreate($post);
}