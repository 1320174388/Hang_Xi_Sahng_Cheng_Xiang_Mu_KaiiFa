<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  InfoDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/24 21:52
 *  文件描述 :  处理信息数据逻辑
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\dao;
use think\Db;
use app\talk_module\working_version\v1\model\PeopleModel;
use app\talk_module\working_version\v1\model\LeavingModel;
use app\talk_module\working_version\v1\model\MessageModel;
use app\talk_module\working_version\v1\model\FormModel;

class InfoDao implements InfoInterface
{
    /**
     * 名  称 : problemCreate()
     * 功  能 : 添加提问信息逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['peopleIndex']  = '用户身份标识';
     * 输  入 : (String) $post['peopleFormid'] = '用户提交表单id';
     * 输  入 : (String) $post['peopleName']   = '用户名称';
     * 输  入 : (String) $post['peopleSex']    = '用户性别';
     * 输  入 : (String) $post['leavingTitle'] = '问题标题';
     * 输  入 : (String) $post['messageCont']  = '问题内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function problemCreate($post)
    {
        // 启动事务
        Db::startTrans();
        try{

            // 判断留言人是否已有留言
            $user = PeopleModel::where('people_index',$post['peopleIndex'])
                ->find();

            // 执行留言人处理逻辑
            if($user) {
                // 处理数据格式
                $user->people_name   = $post['peopleName'];
                $user->people_sex    = $post['peopleSex'];
                $user->people_status = 1;
                $user->people_formid = $post['peopleFormid'];
                // 执行写入数据
                $user->save();
            } else {
                // 实例化模型
                $peopleModel = new PeopleModel();
                // 处理数据
                $peopleModel->people_index  = $post['peopleIndex'];
                $peopleModel->people_name   = $post['peopleName'];
                $peopleModel->people_sex    = $post['peopleSex'];
                $peopleModel->people_status = 1;
                $peopleModel->people_time   = time();
                $peopleModel->people_formid = $post['peopleFormid'];
                // 保存数据
                $peopleModel->save();
            }

            // 实例化留言信息模型
            $leavingModel = new LeavingModel();
            // 生成信息主键信息
            $leavingIndex = md5(uniqid().mt_rand(1,999999));
            // 处理数据
            $leavingModel->leaving_index  = $leavingIndex;
            $leavingModel->people_index   = $post['peopleIndex'];
            $leavingModel->leaving_title  = $post['leavingTitle'];
            $leavingModel->leaving_status = 1;
            $leavingModel->leaving_time   = time();
            // 保存数据
            $leavingModel->save();

            // 实例化留言信息内容模型
            $messageModel = new MessageModel();
            // 生成信息内容主键信息
            $messageIndex = md5(uniqid().mt_rand(1,999999));
            // 处理数据
            $messageModel->message_index    = $messageIndex;
            $messageModel->leaving_index    = $leavingIndex;
            $messageModel->message_content  = $post['messageCont'];
            $messageModel->message_identity = 'User';
            $messageModel->message_sort     = 1;
            // 保存数据
            $messageModel->save();

            // 提交事务
            Db::commit();
            return returnData('success','提问成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return returnData('error','提问失败');
        }
    }

    /**
     * 名  称 : leavingSelect()
     * 功  能 : 获取提问信息逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['peopleIndex']  = '用户身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function leavingSelect($get)
    {
        // 获取用户提问信息
        $data = LeavingModel::where(
            'people_index',
            $get['peopleIndex']
        )->order(
            'leaving_status',
            'asc'
        )->select();
        // 判断是返回成功
        if(!$data) return returnData('error','没有数据');
        // 返回正确数据
        return returnData('success',$data);
    }

    /**
     * 名  称 : adminCreate()
     * 功  能 : 获取管理员formid
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['adminFormid'] = '管理员formid';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function adminCreate($post)
    {
        // 实例化模型
        $formModel = new FormModel();
        // 处理数据
        $formModel->form_index = md5(uniqid().mt_rand(1,999999));
        $formModel->form_id    = $post['adminFormid'];
        $formModel->form_time  = time();
        // 保存数据
        $res = $formModel->save();
        // 验证数据
        if(!$res) return returnData('error','保存失败');
        // 返回正确数据
        return returnData('success','保存成功');
    }

    /**
     * 名  称 : messageSelect()
     * 功  能 : 获取聊天详细内容
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['leavingIndex'] = '提问问题标识';;
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function messageSelect($get)
    {
        // 获取数据
        $list = MessageModel::where(
            'leaving_index',
            $get['leavingIndex']
        )->order(
            'message_sort',
            'asc'
        )->select();
        // 判断是否有数据
        if(!$list) return returnData('error','数据获取失败');
        // 返回正确数据
        return returnData('success',$list);
    }

    /**
     * 名  称 : leavingCreate()
     * 功  能 : 用户继续提问信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['peopleIndex']  => '用户身份标识';
     * 输  入 : (String) $post['peopleFormid'] => '用户提交表单id';
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function leavingCreate($post)
    {
        // 启动事务
        Db::startTrans();
        try{

            // 判断留言人是否已有留言
            $user = PeopleModel::where(
                'people_index',
                $post['peopleIndex']
            )->find();

            // 处理数据格式
            $user->people_status = 1;
            $user->people_formid = $post['peopleFormid'];
            // 执行写入数据
            $user->save();

            // 获取当先聊天数据条数
            $messageNum = MessageModel::where(
                'leaving_index',
                $post['leavingIndex']
            )->count();

            // 获取问题数据
            $leav = LeavingModel::get($post['leavingIndex']);
            // 修改信息状态
            $leav->leaving_status = 1;
            // 保存
            $leav->save();

            // 实例化留言信息内容模型
            $messageModel = new MessageModel();
            // 生成信息内容主键信息
            $messageIndex = md5(uniqid().mt_rand(1,999999));
            // 处理数据
            $messageModel->message_index    = $messageIndex;
            $messageModel->leaving_index    = $post['leavingIndex'];
            $messageModel->message_content  = $post['messageCont'];
            $messageModel->message_identity = 'User';
            $messageModel->message_sort     = $messageNum+1;
            // 保存数据
            $messageModel->save();

            // 提交事务
            Db::commit();
            return returnData('success',['user'=>$user,'leav'=>$leav]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return returnData('error','提交失败');
        }
    }

    /**
     * 名  称 : peopleSelect()
     * 功  能 : 获取所有用户信息
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/26 18:51
     */
    public function peopleSelect()
    {
        // 获取所有用户数据
        $userList = PeopleModel::order(
            'people_status',
            'asc'
        )->select();
        // 判断是否回去到数据
        if(!$userList) return returnData('error','当前没有用户提问');
        // 返回正确数据
        return returnData('success',$userList);
    }

    /**
     * 名  称 : sessionCreate()
     * 功  能 : 客服回复用户信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/26 19:22
     */
    public function sessionCreate($post)
    {
        // 启动事务
        Db::startTrans();
        try{
            // 获取当先聊天数据条数
            $messageNum = MessageModel::where(
                'leaving_index',
                $post['leavingIndex']
            )->count();

            // 获取问题数据
            $leav = LeavingModel::get($post['leavingIndex']);
            // 修改信息状态
            $leav->leaving_status = 2;
            $leav->leaving_handle = '客服';
            // 保存
            $leav->save();

            // 获取留言人信息
            $user = PeopleModel::where(
                'people_index',
                $leav['people_index']
            )->find();
            // 处理数据格式
            $user->people_status = 2;
            // 执行写入数据
            $user->save();

            // 实例化留言信息内容模型
            $messageModel = new MessageModel();
            // 生成信息内容主键信息
            $messageIndex = md5(uniqid().mt_rand(1,999999));
            // 处理数据
            $messageModel->message_index    = $messageIndex;
            $messageModel->leaving_index    = $post['leavingIndex'];
            $messageModel->message_content  = $post['messageCont'];
            $messageModel->message_identity = 'Admin';
            $messageModel->message_sort     = $messageNum+1;
            // 保存数据
            $messageModel->save();

            // 提交事务
            Db::commit();
            return returnData('success',['user'=>$user,'leav'=>$leav]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return returnData('error','回复失败');
        }
    }
}