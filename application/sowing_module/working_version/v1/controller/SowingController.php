<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SowingController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图控制器
 *  历史记录 :  -----------------------
 */
namespace app\sowing_module\working_version\v1\controller;
use think\Controller;
use app\sowing_module\working_version\v1\service\SowingService;

class SowingController extends Controller
{
    /**
     * 名  称 : sowingGet()
     * 功  能 : 获取轮播图列表接口
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"请求数据"}
     * 创  建 : 2018/08/25 17:06
     */
    public function sowingGet(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $sowingService = new SowingService();

        // 获取传入参数
        $get = $request->get();

        // 执行Service逻辑
        $res = $sowingService->sowingShow($get);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S','请求成功');
    }

    /**
     * 名  称 : sowingPost()
     * 功  能 : 添加轮播图接口
     * 变  量 : --------------------------------------
     * 输  入 : $post['sowingFile']  => '轮播图文件资源';
     * 输  入 : $post['sowingSort']  => '轮播图排序数字';
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":true}
     * 创  建 : 2018/08/25 14:47
     */
    public function sowingPost(\think\Request $request)
    {
        // 实例化Service层逻辑类
        $sowingService = new SowingService();

        // 获取传入参数
        $post = $request->post();

        // 执行Service逻辑
        $res = $sowingService->sowingAdd($post);

        // 处理函数返回值
        return \RSD::wxReponse($res,'S');
    }
}
