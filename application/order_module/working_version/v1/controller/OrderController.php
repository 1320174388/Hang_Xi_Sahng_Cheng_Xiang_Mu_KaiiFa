<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderController.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 10:18
 *  文件描述 :  订单控制器
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\controller;
use app\order_module\working_version\v1\service\OrderService;
class OrderController
{
    /**
     * 名    称:  paymentOrder()
     * 功    能: 预支付订单接口
     * 输    入：(string) $POST['order_number']    => `订单号`
     * 输    入：(string) $POST['user_token']      => `用户标识`
     * 输    入：(string) $POST['order_people']    => `收件人名称`
     * 输    入：(string) $POST['order_phone']     => `收件人电话`
     * 输    入：(string) $POST['order_address']   => `收件人地址`
     * 输    入：(string) $POST['order_formd']     => `表单提交ID`
     * 输    入：(string) $POST['good_prices']     => `商品总价格`
     * 输    入：(int)    $POST['order_gdnu']      => `商品数量`
     * 输    入：(string) $POST['order_group']     => `商品信息`
     * 输    出：{"errNum":0,"retMsg":"创建订单成功","retData": true}
     * 输    出：{"errNum":1,"retMsg":"创建订单失败","retData": '提示信息'}
     */
    public function paymentOrder()
    {
        //订单数据处理
        $dataObject = new OrderService();
        $reult = $dataObject->orderData($_POST);
        //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'创建订单成功',true);
        }else{
            return returnResponse(1,'创建订单失败',$reult['data']);
        }
    }
    /**
     * 名    称：getUserOrderList()
     * 功    能：获取用户订单列表
     * 输    入：(string)  $GET['user_token']  =>   用户标识
     * 输    出：{"errNum":0,"retMsg":"获取成功","retData": '订单数据'}
     * 输    出：{"errNum":1,"retMsg":"获取失败","retData": '提示信息'}
     */
    public function getUserOrderList()
    {
        $dataObject = new OrderService();
        //传入token获取订单
       $reult = $dataObject->orderSingleList($_GET);
       //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'获取成功',$reult['data']);
        }else{
            return returnResponse(1,'获取失败',$reult['data']);
        }
    }
    /**
     * 名    称：getAllOrderList()
     * 功    能：获取全部订单列表
     * 输    出：{"errNum":0,"retMsg":"获取成功","retData": '订单数据'}
     * 输    出：{"errNum":1,"retMsg":"获取失败","retData": '提示信息'}
     */
    public function getAllOrderList()
    {

        $dataOpject = new OrderService();
        //执行查询 获取数据
        $reult = $dataOpject->orderAllList();
        //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'获取成功',$reult['data']);
        }else{
            return returnResponse(1,'获取失败',$reult['data']);
        }
    }
    /**
     * 名    称：getOrderDetails()
     * 功    能：获取订单详细数据
     * 输    入：(string)  $order_number =>  `订单号`
     * 输    出：{"errNum":0,"retMsg":"获取成功","retData": '订单数据'}
     * 输    出：{"errNum":1,"retMsg":"获取失败","retData": '提示信息'}
     */
    public function getOrderDetails()
    {
        $orderOpject = new OrderService();
        //执行操作
        $reult = $orderOpject->orderDetails($_GET);
        //返回数据
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'获取成功',$reult['data']);
        }else{
            return returnResponse(1,'获取失败',$reult['data']);
        }
    }
    /**
     * 名    称：setOrderState()
     * 功    能：设置订单状态
     * 输    入：(string)  $order_number       =>  `订单号`
     * 输    入：(int)     $order_status       =>  `订单状态`
     * 输    出：{"errNum":0,"retMsg":"成功","retData": '提示信息'}
     * 输    出：{"errNum":1,"retMsg":"失败","retData": '提示信息'}
     */
    public function setOrderState()
    {
        $orderOpject = new OrderService();
        //执行操作  传入状态碼、订单号
        $reult = $orderOpject->orderState($_GET);
        //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'成功',$reult['data']);
        }else{
            return returnResponse(1,'失败',$reult['data']);
        }
    }
    /**
     * 名    称：orderDoodsComment()
     * 功    能：订单商品评论接口
     * 输    入：(string)  $order_number       =>  `订单号`
     * 输    入：(string)  $user_token         =>  `用户token标识`
     * 输    入：(string)  $good_index         =>  `商品主键`
     * 输    入：(string)  $critic_content     =>  `评论内容`
     * 输    入：(string)  $critic_name        =>  `评论人昵称`
     * 输    出：{"errNum":0,"retMsg":"成功","retData": '提示信息'}
     * 输    出：{"errNum":1,"retMsg":"失败","retData": '提示信息'}
     */
    public function orderDoodsComment()
    {
        $orderOpject = new OrderService();
        //执行操作 传入数据
        $reult = $orderOpject->orderComment($_POST);
        //返回结果
        if ($reult['msg'] == 'success'){
            return returnResponse(0,'评论成功',$reult['data']);
        }else{
            return returnResponse(1,'评论失败',$reult['data']);
        }
    }
}