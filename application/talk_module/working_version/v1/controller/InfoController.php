<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  InfoController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/25 14:49
 *  文件描述 :  问题管理控制器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\controller;
use think\Controller;
use think\Request;
use app\talk_module\working_version\v1\service\InfoService;

class InfoController extends Controller
{
    /**
     * 名  称 : infoPost()
     * 功  能 : 用户添加问题接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['peopleIndex']  = '用户身份标识';
     * 输  入 : (String) $post['peopleFormid'] = '用户提交表单id';
     * 输  入 : (String) $post['peopleName']   = '用户名称';
     * 输  入 : (String) $post['peopleSex']    = '用户性别';
     * 输  入 : (String) $post['leavingTitle'] = '问题标题';
     * 输  入 : (String) $post['messageCont']  = '问题内容';
     * 输  出 : {"errNum":0,"retMsg":"提问成功","retData":true}
     * 创  建 : 2018/07/25 14:54
     */
    public function infoPost(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行添加自动回复信息逻辑,获取逻辑返回值
        $res = $infoService->infoAdd($request->post());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : infoGet()
     * 功  能 : 用户获取问题接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['peopleIndex']  = '用户身份标识';
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"数据"}
     * 创  建 : 2018/07/25 14:54
     */
    public function infoGet(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行添加自动回复信息逻辑,获取逻辑返回值
        $res = $infoService->infoAll($request->get());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : adminPost()
     * 功  能 : 获取管理员formid
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['adminFormid'] = '管理员formid';
     * 输  出 : {"errNum":0,"retMsg":"添加成功","retData":true}
     * 创  建 : 2018/07/25 14:54
     */
    public function adminPost(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行添加自动回复信息逻辑,获取逻辑返回值
        $res = $infoService->adminAdd($request->post());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : infoDetails()
     * 功  能 : 获取聊天详细内容
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['leavingIndex'] = '提问问题标识';
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"数据"}
     * 创  建 : 2018/07/25 14:54
     */
    public function infoDetails(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行获取自动回复信息逻辑,获取逻辑返回值
        $res = $infoService->infoDetailsAll($request->get());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : infoDoPost()
     * 功  能 : 用户继续提问信息处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['peopleIndex']  => '用户身份标识';
     * 输  入 : (String) $post['peopleFormid'] => '用户提交表单id';
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : {"errNum":0,"retMsg":"提交成功","retData":true}
     * 创  建 : 2018/07/26 16:39
     */
    public function infoDoPost(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行添加用户再次提问信息接口
        $res = $infoService->infoDoAdd($request->post());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : userGet()
     * 功  能 : 获取所有用户信息
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"数据"}
     * 创  建 : 2018/07/26 18:51
     */
    public function userGet()
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行获取用户信息功能
        $res = $infoService->userAll();
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : adminReply()
     * 功  能 : 客服回复用户信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : {"errNum":0,"retMsg":"回复成功","retData":true}
     * 创  建 : 2018/07/26 19:22
     */
    public function adminReply(Request $request)
    {
        // 实例化Service逻辑层代码类
        $infoService = new InfoService();
        // 执行添加客服回复信息
        $res = $infoService->sessionAdd($request->post());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }
}