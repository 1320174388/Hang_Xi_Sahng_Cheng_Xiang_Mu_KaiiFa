<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  NocticeController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 14:29
 *  文件描述 :  公告信息控制器
 *  历史记录 :  -----------------------
 */
namespace app\noctice_module\working_version\v1\controller;
use think\Controller;
use app\noctice_module\working_version\v1\service\NocticeService;

class NocticeController extends Controller
{
    /**
     * 名  称 : nocticeGet()
     * 功  能 : 获取公告信息数据
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"公告信息"}
     * 创  建 : 2018/08/06 14:33
     */
    public function nocticeGet()
    {
        // 示例话逻辑层代码
        $nocticeService = new NocticeService();
        // 执行逻辑层代码
        $res = $nocticeService->nocticeSel();
        // 验证返回数据
        if($res['msg']=='error') return returnResponse(
            1,
            $res['data']
        );
        // 返回正确数据
        return returnResponse(0,'请求成功',$res['data']);
    }

    /**
     * 名  称 : nocticePut()
     * 功  能 : 修改公告信息数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['nocticeIndex']   => '公告主键';
     * 输  入 : (String) $put['nocticeContent'] => '公告内容';
     * 输  出 : {"errNum":0,"retMsg":"修改成功","retData":"公告内容"}
     * 创  建 : 2018/08/06 15:52
     */
    public function nocticePut($put)
    {
        // 示例话逻辑层代码
        $nocticeService = new NocticeService();
        // 执行逻辑层代码
        $res = $nocticeService->nocticeEdit($put);
        // 验证返回数据
        if($res['msg']=='error') return returnResponse(
            1,
            $res['data']
        );
        // 返回正确数据
        return returnResponse(0,'修改成功',$res['data']);
    }
}