<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/30 10:17
 *  文件描述 :  商品管理业务逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\service;
use app\good_module\working_version\v1\dao\GoodDao;
use app\good_module\working_version\v1\validator\GoodValidate;

class GoodService
{
    /**
     * 名  称 : goodAdd()
     * 功  能 : 处理商品信息数据
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
    public function goodAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $goodValidate = new GoodValidate();
        // 判断数据是否正确,返回错误数据
        if(!$goodValidate->check($post))
        {
            return returnData(
                'error',
                $goodValidate->getError()
            );
        }

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodCreate($post);
        // 判断数据是否写入成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }
}