<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  InfoService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/24 21:36
 *  文件描述 :  信息控制器
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\service;
use app\login_module\working_version\v1\model\UserModel;
use app\talk_module\working_version\v1\model\FormModel;
use app\talk_module\working_version\v1\dao\InfoDao;
use app\talk_module\working_version\v1\validator\ProblemValidate;
use app\talk_module\working_version\v1\validator\LeavingValidate;
use app\talk_module\working_version\v1\validator\SessionValidate;
use app\talk_module\working_version\v1\library\PushLibrary;

class InfoService
{
    /**
     * 名  称 : infoAdd()
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
    public function infoAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $validate = new ProblemValidate();
        // 判断数据是否正确,返回错误数据
        if(!$validate->check($post))
        {
            return returnData('error',$validate->getError());
        }

        // 实例化ReplyDao层代码
        $replydao = new InfoDao();
        // 执行添加数据逻辑
        $res = $replydao->problemCreate($post);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);

        // 获取最高管理员openid
        $userModel = new UserModel();
        // 加载配置项表信息
        $userModel->userInit();
        // 查询用户信息
        $user = $userModel->where('user_id',1)->find();

        // 删除超过一个星期的formid
        FormModel::where(
            'form_time',
            '<',
            time()-(60*60*24*7)
        )->delete();

        // 获取管理员formid
        $formid = FormModel::order(
            'form_time',
            'asc'
        )->find();

        if($formid){
            // 处理模板消息数据
            $data = [
                'touser'           => $user['user_openid'],
                'template_id'      => config('wx_config.PushAdmin'),
                'page'             => '/pages/kefu/adminManage/adminManage',
                'form_id'          => $formid['form_id'],
                'data'             => [
                    'keyword1'=>['value'=>$post['peopleName']],
                    'keyword2'=>['value'=>$post['leavingTitle']],
                    'keyword3'=>['value'=>$post['messageCont']],
                    'keyword4'=>['value'=>date('Y-m-d H:i',time())],
                ],
            ];
            // 实例化模板消息推送接口
            $pushLibrary = new PushLibrary();
            // 发送模板消息
            $pushLibrary->sendTemplate($data);
            // 删除formid
            $formid->delete();
        }
        // 返回正确格式
        return returnData('success',$res['data']);

    }

    /**
     * 名  称 : infoAll()
     * 功  能 : 获取提问信息逻辑
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['peopleIndex']  = '用户身份标识';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function infoAll($get)
    {
        // 判断用户是否发送身份标识
        if(empty($get['peopleIndex'])){
            return returnData('error','请发送用户身份标识');
        }
        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行获取数据逻辑
        $res = $replydao->leavingSelect($get);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);
        // 返回正确格式
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : adminAdd()
     * 功  能 : 获取管理员formid
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['adminFormid'] = '管理员formid';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function adminAdd($post)
    {
        // 判断用户是否发送身份标识
        if(empty($post['adminFormid'])){
            return returnData('error','请发送管理员formid');
        }
        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行获取数据逻辑
        $res = $replydao->adminCreate($post);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);
        // 返回正确格式
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : infoDetailsAll()
     * 功  能 : 获取聊天详细内容
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['leavingIndex'] = '提问问题标识';;
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function infoDetailsAll($get)
    {
        // 判断用户是否发送提问问题标识
        if(empty($get['leavingIndex'])){
            return returnData('error','请发送问题标识');
        }
        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行获取数据逻辑
        $res = $replydao->messageSelect($get);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);
        // 返回正确格式
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : infoDoAdd()
     * 功  能 : 用户继续提问信息处理
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['peopleIndex']  => '用户身份标识';
     * 输  入 : (String) $post['peopleFormid'] => '用户提交表单id';
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/24 17:58
     */
    public function infoDoAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $validate = new LeavingValidate();
        // 判断数据是否正确,返回错误数据
        if(!$validate->check($post))
        {
            return returnData('error',$validate->getError());
        }

        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行添加数据逻辑
        $res = $replydao->leavingCreate($post);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);

        // 获取最高管理员openid
        $userModel = new UserModel();
        // 加载配置项表信息
        $userModel->userInit();
        // 查询用户信息
        $user = $userModel->where('user_id',1)->find();

        // 删除超过一个星期的formid
        FormModel::where(
            'form_time',
            '<',
            time()-(60*60*24*7)
        )->delete();

        // 获取管理员formid
        $formid = FormModel::order(
            'form_time',
            'asc'
        )->find();

        if($formid){
            // 处理模板消息数据
            $data = [
                'touser'           => $user['user_openid'],
                'template_id'      => config('wx_config.PushAdmin'),
                'page'             => '/pages/kefu/adminManage/adminManage',
                'form_id'          => $formid['form_id'],
                'data'             => [
                    'keyword1'=>['value'=>$res['data']['user']['people_name']],
                    'keyword2'=>['value'=>$res['data']['leav']['leaving_title']],
                    'keyword3'=>['value'=>$post['messageCont']],
                    'keyword4'=>['value'=>date('Y-m-d H:i',time())],
                ],
            ];
            // 实例化模板消息推送接口
            $pushLibrary = new PushLibrary();
            // 发送模板消息
            $pushLibrary->sendTemplate($data);
            // 删除formid
            $formid->delete();
        }

        // 返回正确格式
        return returnData('success','提交成功');

    }

    /**
     * 名  称 : userAll()
     * 功  能 : 获取所有用户信息
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/26 18:51
     */
    public function userAll()
    {
        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行获取数据逻辑
        $res = $replydao->peopleSelect();
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);
        // 返回正确格式
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : sessionAdd()
     * 功  能 : 客服回复用户信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['leavingIndex'] => '问题标识';
     * 输  入 : (String) $post['messageCont']  => '问题内容';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/07/26 19:57
     */
    public function sessionAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $validate = new SessionValidate();
        // 判断数据是否正确,返回错误数据
        if(!$validate->check($post))
        {
            return returnData('error',$validate->getError());
        }

        // 实例化InfoDao层代码
        $replydao = new InfoDao();
        // 执行添加数据逻辑
        $res = $replydao->sessionCreate($post);
        // 判断返回值，返回错误信息
        if($res['msg']=='error') return returnData('error',$res['data']);

        // 获取最高管理员openid
        $userModel = new UserModel();
        // 加载配置项表信息
        $userModel->userInit();
        // 查询用户信息
        $user = $userModel->where(
            'user_token',
            $res['data']['user']['people_index']
            )->find();

        // 处理模板消息数据
        $data = [
            'touser'           => $user['user_openid'],
            'template_id'      => config('wx_config.PushUser'),
            'page'             => '/pages/kefu/ask/ask',
            'form_id'          => $res['data']['user']['people_formid'],
            'data'             => [
                'keyword1'=>['value'=>$res['data']['leav']['leaving_handle']],
                'keyword2'=>['value'=>$post['messageCont']],
                'keyword3'=>['value'=>date('Y-m-d H:i',time())],
            ],
        ];
        // 实例化模板消息推送接口
        $pushLibrary = new PushLibrary();
        // 发送模板消息
        $pushLibrary->sendTemplate($data);
        // 返回正确格式
        return returnData('success','回复成功');
    }
}