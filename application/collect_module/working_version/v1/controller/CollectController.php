<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  CollectController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/01 10:08
 *  文件描述 :  个人收藏控制器
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\controller;
use think\Controller;
use think\Request;
use app\collect_module\working_version\v1\service\CollectService;

class CollectController extends Controller
{
    /**
     * 名  称 : collectPost()
     * 功  能 : 添加收藏信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 输  出 : {"errNum":0,"retMsg":"添加成功","retData":true}
     * 创  建 : 2018/08/01 10:08
     */
    public function collectPost(Request $request)
    {
        // 实例化Service业务逻辑代码
        $collectService = new CollectService();
        // 获取传值数据
        $post = $request->post();
        // 执行业务逻辑处理
        $res = $collectService->collectAdd($post);
        // 验证返回数据
        if($res['msg']=='error')
        {
            return returnResponse(
                1, $res['data']
            );
        }
        // 返回正确数据
        return returnResponse(0,$res['data'],true);

    }
}