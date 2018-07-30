<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ReplyController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/24 14:49
 *  文件描述 :  自动回复控制器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\controller;
use think\Controller;
use think\Request;
use app\talk_module\working_version\v1\service\ReplyService;

class ReplyController extends Controller
{
    /**
     * 名  称 : replyPost()
     * 功  能 : 添加自动回复信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['sessionName'] = '触发标识';
     * 输  入 : (String) $post['sessionType'] = '信息类型';
     * 输  入 : (String) $post['sessionCont'] = '回复内容';
     * 输  出 : {"errNum":0,"retMsg":"添加成功","retData":true}
     * 创  建 : 2018/07/24 17:58
     */
    public function replyPost(Request $request)
    {
        // 实例化Service逻辑层代码类
        $replyService = new ReplyService();
        // 执行添加自动回复信息逻辑,获取逻辑返回值
        $res = $replyService->replyAdd($request->post());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : replyGet()
     * 功  能 : 获取自动回复信息
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : {"errNum":0,"retMsg":"请求成功","retData":"数据"}
     * 创  建 : 2018/07/25 09:57
     */
    public function replyGet()
    {
        // 实例化Service逻辑层代码类
        $replyService = new ReplyService();
        // 执行获取自动回复信息逻辑,获取逻辑返回值
        $res = $replyService->replyAll();
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : replyPut()
     * 功  能 : 修改自动回复信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['sessionIndex'] = '信息主键';
     * 输  入 : (String) $put['sessionName']  = '触发标识';
     * 输  入 : (String) $put['sessionType']  = '信息类型';
     * 输  入 : (String) $put['sessionCont']  = '回复内容';
     * 输  出 : {"errNum":0,"retMsg":"修改成功","retData":true}
     * 创  建 : 2018/07/25 10:28
     */
    public function replyPut(Request $request)
    {
        // 实例化Service逻辑层代码类
        $replyService = new ReplyService();
        // 执行修改自动回复信息逻辑,获取逻辑返回值
        $res = $replyService->replyEdit($request->put());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }

    /**
     * 名  称 : replyDel()
     * 功  能 : 修改自动回复信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['sessionIndex'] = '信息主键';
     * 输  出 : {"errNum":0,"retMsg":"删除成功","retData":true}
     * 创  建 : 2018/07/25 11:04
     */
    public function replyDel(Request $request)
    {
        // 实例化Service逻辑层代码类
        $replyService = new ReplyService();
        // 执行删除自动回复信息逻辑,获取逻辑返回值
        $res = $replyService->replyDel($request->delete());
        // 根据逻辑返回值返回数据,返回错误格式
        if($res['msg']=='error') return returnResponse(1,$res['data']);
        // 返回正确数据
        return returnResponse(0,$res['data'],true);
    }
}