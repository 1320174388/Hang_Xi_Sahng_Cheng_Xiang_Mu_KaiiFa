<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  NocticeService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 14:35
 *  文件描述 :  公告信息逻辑处理
 *  历史记录 :  -----------------------
 */
namespace app\noctice_module\working_version\v1\service;
use app\noctice_module\working_version\v1\dao\NocticeDao;
use app\noctice_module\working_version\v1\validator\NocticeValidate;

class NocticeService
{
    /**
     * 名  称 : nocticeSel()
     * 功  能 : 获取公告信息数据
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'公共信息']
     * 创  建 : 2018/08/06 14:37
     */
     public function nocticeSel()
     {
         // 实例化数据逻辑类
         $nocticeDao = new NocticeDao();
         // 获取公告信息
         $data = $nocticeDao->nocticeSelect();
         // 判断是否有公告信息
         if($data['msg']=='error') return returnData(
             'error',
             $data['data']
         );
         // 返回正确信息
         return returnData('success',$data['data']);
     }

    /**
     * 名  称 : nocticeEdit()
     * 功  能 : 修改公告信息数据
     * 输  入 : (String) $put['nocticeIndex']   => '公告主键';
     * 输  入 : (String) $put['nocticeContent'] => '公告内容';
     * 输  出 : ['msg'=>'success','data'=>'公共信息']
     * 创  建 : 2018/08/06 16:13
     */
     public function nocticeEdit($put)
     {
         // 实例化验证器，验证数据是否正确
         $nocticeValidate = new NocticeValidate();
         // 判断数据是否正确,返回错误数据
         if(!$nocticeValidate->check($put))
         {
             return returnData(
                 'error',
                 $nocticeValidate->getError()
             );
         }

         // 实例化数据逻辑类
         $nocticeDao = new NocticeDao();
         // 获取公告信息
         $data = $nocticeDao->nocticeUpdate($put);
         // 判断是否有公告信息
         if($data['msg']=='error') return returnData(
             'error',
             $data['data']
         );
         // 返回正确信息
         return returnData('success',$data['data']);
     }
}