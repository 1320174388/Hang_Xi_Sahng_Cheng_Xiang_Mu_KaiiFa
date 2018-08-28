<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SowingService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\sowing_module\working_version\v1\service;
use app\sowing_module\working_version\v1\dao\SowingDao;
use app\sowing_module\working_version\v1\library\SowingLibrary;

class SowingService
{
    /**
     * 名  称 : sowingShow()
     * 功  能 : 获取轮播图列表逻辑
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/25 17:06
     */
    public function sowingShow($get)
    {
        // 实例化Dao层数据类
        $sowingDao = new SowingDao();

        // 执行Dao层逻辑
        $res = $sowingDao->sowingSelect($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }

    /**
     * 名  称 : sowingAdd()
     * 功  能 : 添加轮播图逻辑
     * 变  量 : --------------------------------------
     * 输  入 : $post['sowingFile']  => '轮播图文件资源';
     * 输  入 : $post['sowingSort']  => '轮播图排序数字';
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/25 14:47
     */
    public function sowingAdd($post)
    {
        // 验证数据是否发送排序信息
        if(empty($post['sowingSort'])){
            return returnData('error','请发送轮播图排序');
        }

        // 判断文件资源是否上传
        $imageUploads = imageUploads(
            'sowingFile',
            './uploads/sowing/',
            '/uploads/sowing/'
        );
        if($imageUploads['msg']=='error'){
            return returnData('error','请发送文件数据名称');
        }
        $post['sowingFile'] = $imageUploads['data'];

        // 实例化Dao层数据类
        $sowingDao = new SowingDao();

        // 执行Dao层逻辑
        $res = $sowingDao->sowingCreate($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'D');
    }
}
