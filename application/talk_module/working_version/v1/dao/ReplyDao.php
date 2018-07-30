<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  ReplyDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/24 21:52
 *  文件描述 :  自动回复数据逻辑
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\dao;
use think\Db;
use app\talk_module\working_version\v1\model\ReplyModel;

class ReplyDao implements ReplyInterface
{
    /**
     * 名  称 : replyCreate()
     * 功  能 : 添加自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['sessionName'] = '触发标识';
     * 输  入 : (String) $post['sessionType'] = '信息类型';
     * 输  入 : (String) $post['sessionCont'] = '回复内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 21:54
     */
    public function replyCreate($post)
    {
        // 获取触发标识数据，查看是否存在
        $data = ReplyModel::where(
            'session_name',
            $post['sessionName']
        )->find();
        // 验证数据
        if($data) return returnData('error','问题已经存在');
        // 实例化，数据模型
        $replyModel = new ReplyModel();
        // 处理数据
        $replyModel->session_index   = md5(uniqid());
        $replyModel->session_name    = $post['sessionName'];
        $replyModel->session_type    = $post['sessionType'];
        $replyModel->session_content = $post['sessionCont'];
        $replyModel->session_time    = time();
        // 保存数据
        $res = $replyModel->save();
        // 判断数据是否保存成功
        if($res['msg']) return returnData('error','添加失败');
        // 返回正确数据
        return returnData('success','添加成功');
    }

    /**
     * 名  称 : replySelect()
     * 功  能 : 获取自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:02
     */
    public function replySelect()
    {
        // 获取所有自动回复信息
        $all = ReplyModel::all();
        // 根据返回数据判断是否获取成功
        if(!$all) return returnData('error','当前没有添加任何自动回复信息');
        // 返回正确数据
        return returnData('success',$all);
    }

    /**
     * 名  称 : replyUpdate()
     * 功  能 : 修改自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['sessionIndex'] = '信息主键';
     * 输  入 : (String) $put['sessionName']  = '触发标识';
     * 输  入 : (String) $put['sessionType']  = '信息类型';
     * 输  入 : (String) $put['sessionCont']  = '回复内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:36
     */
    public function replyUpdate($put)
    {
        // 获取触发标识数据，查看是否存在
        $data = ReplyModel::where(
            'session_name',
            $put['sessionName']
        )->find();
        // 验证数据
        if(($data)&&($put['sessionIndex']!=$data['session_index']))
        {
            return returnData('error','问题已经存在');
        }

        try{
            // 获取要修改的数据
            $reply = ReplyModel::get($put['sessionIndex']);
            // 处理数据
            $reply->session_name    = $put['sessionName'];
            $reply->session_type    = $put['sessionType'];
            $reply->session_content = $put['sessionCont'];
            // 执行最终修改
            $reply->save();
            // 提交事务
            Db::commit();
            // 返回正确数据
            return returnData('success','修改成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // 返回正确数据
            return returnData('success','修改失败');
        }


    }

    /**
     * 名  称 : replyDelete()
     * 功  能 : 删除自动回复数据逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['sessionIndex'] = '信息主键';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/25 10:36
     */
    public function replyDelete($delete)
    {
        // 获取删除的数据
        $reply = ReplyModel::get($delete['sessionIndex']);
        // 删除数据
        $res = $reply->delete();
        // 判断删除是否成功、
        if(!$res) return returnData('error','删除失败');
        // 返回正确数据
        return returnData('success','删除成功');
    }
}