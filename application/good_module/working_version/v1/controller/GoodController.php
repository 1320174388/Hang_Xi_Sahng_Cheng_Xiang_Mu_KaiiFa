<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodController.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/30 20:43
 *  文件描述 :  商品管理控制器
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\controller;
use think\Controller;
use think\Request;
use app\good_module\working_version\v1\service\GoodService;

class GoodController extends Controller
{
    /**
     * 名  称 : goodPost()
     * 功  能 : 添加商品信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodName']  => '商品名称'
     * 输  入 : (String) $post['goodPrice'] => '商品价格'
     * 输  入 : (String) $post['goodSales'] => '商品销量'
     * 输  入 : (String) $post['goodStyle'] => '{
     *              {"styleName":"规格名称","stylePrice":"规格价格"}
     *          }'
     * 输  出 : {"errNum":0,"retMsg":"添加成功","retData":"商品主键"}
     * 创  建 : 2018/07/31 10:11
     */
    public function goodPost(Request $request)
    {
        // 实例化Service业务逻辑代码
        $goodService = new GoodService();
        // 获取传值数据
        $post = $request->post();
        // 执行业务逻辑处理
        $res = $goodService->goodAdd($post);
        // 验证返回数据
        if($res['msg']=='error')
        {
            return returnResponse(
                1, $res['data']
            );
        }
        // 返回正确数据
        return returnResponse(0,'添加成功',$res['data']);

    }
}