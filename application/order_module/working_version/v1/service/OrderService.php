<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderService.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 12:18
 *  文件描述 :  订单数据验证逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\service;
//引人数据操作层
use app\order_module\working_version\v1\dao\OrderDao;
//引人订单验证器
use app\order_module\working_version\v1\validator\OrderDataCheck;
//引人商品评价验证器
use app\order_module\working_version\v1\validator\GoodsComment;
use think\Validate;
use think\Db;

class OrderService
{
    /**
     * 名    称：OrderData()
     * 功    能：订单数据处理
     * 输    入：(array) $data     =>  `订单数据`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderData($data)
    {
        //数据检测
        $dataCheck = new OrderDataCheck();

        if (!$dataCheck->check($data)){
            //数据错误
            return returnData('error',$dataCheck->getError());
        }
        //json数据转化为数组
        $orderGoods = json_decode($data['order_group'],true);
        $data['many'] = $orderGoods;

        //默认未付款状态
        $data['order_status'] = 1;

        //执行添加数据库
        $orderObject = new OrderDao();
        $reult = $orderObject->insertOrder($data);

        //返回执行结果
        if ($reult['msg'] == 'success')
        {
            return returnData('success',$reult['data']);
        }else{
            return returnData('error',$reult['data']);
        }
    }
    /**
     * 名    称：orderSingleList()
     * 功    能：获取用户订单列表
     * 输    入：(array) $token     =>  `用户token标识`
     * 输    出：['msg'=>'success','data'=>'订单数据']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderSingleList($token)
    {
        //验证用户token
       $userToken = isset($token['user_token']) ? $token['user_token'] : false;
       if (!$userToken) return returnData('error','用户token不能为空');
       //执行数据操作
        $orderObject = new OrderDao();
        $reult = $orderObject->getSingleList($userToken);
        //返回执行结果
        if ($reult['msg'] == 'success')
        {
            return returnData('success',$reult['data']);
        }else{
            return returnData('error',$reult['data']);
        }
    }
    /**
     * 名    称：orderAllList()
     * 功    能：获取用户订单列表
     * 输    出：['msg'=>'success','data'=>'订单数据']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderAllList()
    {
        $dataOpject = new OrderDao();
        //获取数据
        $reult = $dataOpject->getAllList();
        //返回结果
        if ($reult['msg'] == 'success')
        {
            return returnData('success',$reult['data']);
        }else{
            return returnData('error',$reult['data']);
        }
    }
    /**
     * 名    称：orderDetails()
     * 功    能：获取订单详细数据
     * 输    入：(string)  $data   => `订单号`
     * 输    出：['msg'=>'success','data'=>'订单数据']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderDetails($data)
    {
        //验证订单号
        $orderNumber = isset($data['order_number']) ? $data['order_number'] : false;
        //订单号错误
        if (!$orderNumber) return returnData('error','订单号order_number不能为空');
        //执行数据操作
        $orderOpject = new OrderDao();
        $reult = $orderOpject->getDetails($orderNumber);
        //返回结果
        if ($reult['msg'] == 'success')
        {
            return returnData('success',$reult['data']);
        }else{
            return returnData('error',$reult['data']);
        }
    }
    /**
     * 名    称：orderState()
     * 功    能：设置订单状态
     * 输    入：(array)   $data   =>  `订单号、状态碼`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderState($data)
    {
        //验证数据
        $validate = new Validate([
            'order_number'  => 'require',
            'order_status'  => 'require'
        ],[
            'order_number.require' => '订单号order_number不能为空',
            'order_status.require' => '状态碼order_status不能为空'
        ]);
        //返回数据错误
        if (!$validate->check($data)) {
            return returnData('error',$validate->getError());
        }
        //执行数据操作
        $orderOpject = new OrderDao();
        $reult = $orderOpject->setState($data);
        //返回结果
        if ($reult['msg'] == 'success')
        {
            return returnData('success',$reult['data']);
        }else{
            return returnData('error',$reult['data']);
        }
    }
    /**
     * 名    称：orderComment()
     * 功    能：订单评论
     * 输    入：(array)   $data   =>  `评论信息`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function orderComment($data)
    {
        //验证数据
        $orderComment = new GoodsComment();

        if (!$orderComment->check($data)){
            //数据错误
            return returnData('error',$orderComment->getError());
        }

        $addComment = new OrderDao();
        //开启事务
        Db::startTrans();
        //执行添加评论操作
        $add = $addComment->addGoodsComment($data);
        //添加评论成功
        if ($add['msg'] == 'success'){
            //更新订单评论状态
           $state = $addComment->upCommentState($data);

            //返回结果
            if ($state['msg'] == 'success')
            {
                //提交事务
                Db::commit();
                //评论成功
                return returnData('success',$state['data']);
            }else{
                //事务回滚
                Db::rollback();
                return returnData('error',$state['data']);
            }
        }else{
            //事务回滚
            Db::rollback();
            return returnData('error','评论失败');
        }
    }
}