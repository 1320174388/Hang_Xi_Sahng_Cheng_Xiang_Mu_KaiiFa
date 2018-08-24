<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  OrderDao.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 12:18
 *  文件描述 :  订单数据写入层
 *  历史记录 :  -----------------------
 */
namespace app\order_module\working_version\v1\dao;
use think\Db;
//加载订单详细模型
use app\order_module\working_version\v1\model\OrderDetails;
//加载订单主表模型
use app\order_module\working_version\v1\model\OrderMain;
//加载商品评论模型
use app\good_module\working_version\v1\model\CriticModel;

class OrderDao
{
    /**
     * 名    称： insertOrder()
     * 功    能： 添加订单数据到数据库
     * 输    入： (array)  $data   =>  `订单数据`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function insertOrder($data)
    {
        $order = new OrderMain();
        //获取订单商品详细数据
        $dataMany = $data['many'];
        //获取订单号
        $order_number = $data['order_number'];

        //启动事务
        Db::startTrans();

        try{
            //写入订单表
            $Main = $order->allowField(true)->save($data);
            //写入订单关联表
            $D = $order->find($order_number);
            $details = $D->details()->saveAll($dataMany);
            //提交事务
            Db::commit();
           //返回结果
            if ($Main && $details){
                return returnData('success','添加成功');
            }else{
                return returnData('error','添加失败');
            }
        }catch (\Exception $e){
            //事务回滚
            Db::rollback();
            //返回结果
            return returnData('error','添加失败');
        }
    }
    /**
     * 名    称： getSingleList()
     * 功    能： 查询指定用户订单列表
     * 输    入： (srting)  $token   =>  `用户token标识`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function getSingleList($token)
    {
        $order = new OrderMain();
        //查询订单
       $orderArray = $order->where('user_token',$token)->select();
        $datas = [];
        foreach ($orderArray as $k=>$v) {
            $data =  $order->get($v['order_number']);
            $data->details;
            $datas[$k] = $data;
        }

       //返回结果
        if (count($datas) > 0){
            return returnData('success',$datas);
        }else{
            return returnData('error','没有数据');
        }
    }
    /**
     * 名    称： getAllList()
     * 功    能： 查询所有订单列表
     * 输    出：['msg'=>'success','data'=>'订单数据']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function getAllList($num)
    {
        $dataModel = new OrderMain();
        //查询订单表 查询前12条数据
        $data = [];
        for ($i = 0;$i<=4;$i++)
        {
            $D =  $dataModel->where('order_status',$i)->limit(12*$num,12)->select();
            foreach ($D as $k => $v){
                $data[] = $v;
            }
        }
        $datas = [];
        foreach ($data as $k=>$v) {
            $data =  $dataModel->get($v['order_number']);
            $data->details;
            $datas[$k] = $data;
        }

        //返回结果
        if (count($datas) > 0)
        {
            return returnData('success',$datas);
        }else{
            return returnData('error','没有数据');
        }
    }
    /**
     * 名    称： getDetails()
     * 功    能： 查询订单详细数据
     * 输    入： （string）     $orderNumber    =>  `订单号`
     * 输    出：['msg'=>'success','data'=>'订单数据']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function getDetails($orderNumber)
    {
        $orderOpject = new OrderMain();
        //执行查询
        $data = $orderOpject->get($orderNumber);
        $data->details;

        //返回数据
        if (count($data) > 0)
        {
            return returnData('success',$data);
        }else{
            return returnData('error','没有数据');
        }
    }
    /**
     * 名    称： setState()
     * 功    能： 设置订单状态
     * 输    入：(string)  $order_number       =>  `订单号`
     * 输    入：(int)     $order_status       =>  `订单状态`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function setState($data)
    {
        $orderOpject = new OrderMain();
        //执行数据操作
       $reult = $orderOpject->where('order_number',$data['order_number'])
                            ->update(['order_status' => $data['order_status']]);
       //返回结果
        if ($reult)
        {
            return returnData('success','成功');
        }else{
            return returnData('error','失败');
        }
    }
    /**
     * 名    称： upCommentState()
     * 功    能：更新商品评论状态
     * 输    入：(string)  $order_number       =>  `订单号`
     * 输    入：(string)  $good_index         =>  `商品主键`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function upCommentState($data)
    {
        $orderOpject = new OrderDetails();
        //执行数据库操作
        $reult = $orderOpject->save(['critic_status' => 1],
                                    ['order_number' => $data['order_number'],
                                        'good_index' => $data['good_index']]);
        //返回结果
        if ($reult)
        {
            return returnData('success','更新成功');
        }else{
            return returnData('error','更新失败');
        }
    }
    /**
     * 名    称： addGoodsComment()
     * 功    能：添加商品评论
     * 输    入：(string)  $user_token         =>  `用户标识`
     * 输    入：(string)  $good_index         =>  `商品主键`
     * 输    入：(string)  $critic_name        =>  `评论人昵称`
     * 输    入：(string)  $critic_content     =>  `评论内容`
     * 输    出：['msg'=>'success','data'=>'提示信息']
     * 输    出：['msg'=>'error','data'=>'提示信息']
     */
    public function addGoodsComment($data)
    {
        $commentOpject = new CriticModel();
        //执行添加到数据库
        $reult = $commentOpject->allowField(true)->save($data);
        //返回结果
        if ($reult)
        {
            return returnData('success','添加成功');
        }else{
            return returnData('error','添加失败');
        }
    }

}