<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  NocticeDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 15:17
 *  文件描述 :  公告信息数据接口
 *  历史记录 :  -----------------------
 */
namespace app\noctice_module\working_version\v1\dao;
use app\noctice_module\working_version\v1\model\NocticeModel;

class NocticeDao implements NocticeInterface
{
    /**
     * 名  称 : nocticeSelect()
     * 功  能 : 获取公告信息接口声明
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'公告信息']
     * 创  建 : 2018/08/06 15:06
     */
    public function nocticeSelect()
    {
        // 获取公告信息
        $data = NocticeModel::find();
        // 判断是否有数据
        if(!$data) return returnData(
            'error',
            '没用公告，请联系管理员添加公告信息'
        );
        // 返回正确公告信息
        return returnData('success',$data);
    }

    /**
     * 名  称 : nocticeUpdate()
     * 功  能 : 修改公告信息数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['nocticeIndex']   => '公告主键';
     * 输  入 : (String) $put['nocticeContent'] => '公告内容';
     * 输  出 : ['msg'=>'success','data'=>'公告信息']
     * 创  建 : 2018/08/06 15:06
     */
    public function nocticeUpdate($put)
    {
        // 获取公告信息
        $data = NocticeModel::get($put['nocticeIndex']);
        // 判断是否有数据
        if(!$data) return returnData(
            'error',
            '没用公告，请联系管理员添加公告信息'
        );
        // 修改数据
        $data->notice_content = $put['nocticeContent'];
        // 保存数据
        if(!$data->save()) return returnData(
            'error',
            '修改失败'
        );
        // 返回正确公告信息
        return returnData('success',$put['nocticeContent']);
    }
}