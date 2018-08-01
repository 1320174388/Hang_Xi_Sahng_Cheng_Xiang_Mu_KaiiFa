<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CollectService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/01 10:08
 *  文件描述 :  商品管理业务逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\service;
use app\collect_module\working_version\v1\dao\CollectDao;
use app\collect_module\working_version\v1\validator\CollectValidate;

class CollectService
{
    /**
     * 名  称 : collectAdd()
     * 功  能 : 添加收藏信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/08/01 10:08
     */
    public function collectAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $collectValidate = new CollectValidate();
        // 判断数据是否正确,返回错误数据
        if(!$collectValidate->check($post))
        {
            return returnData(
                'error',
                $collectValidate->getError()
            );
        }

        // 实例化Dao数据操作类，写入数据
        $goodDao = new CollectDao();
        // 执行写入数据操作函数
        $res =  $goodDao->collectCreate($post);
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