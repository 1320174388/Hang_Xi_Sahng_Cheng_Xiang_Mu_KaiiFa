<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  LoginDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 18:00
 *  文件描述 :  数据持久层,操作User：Model模型处理数据
 *  历史记录 :  -----------------------
 */
namespace app\login_module\working_version\v1\dao;
use  app\login_module\working_version\v1\model\UserModel;

class LoginDao
{
    /**
     * 名  称 : loginSelect()
     * 功  能 : 声明：获取用户数据
     * 变  量 : --------------------------------------
     * 输  入 : (string) $openid => '小程序用户openid';
     * 输  出 : [ 'msg' => 'success', 'data' => $userInfo ]
     * 输  出 : [ 'msg' => 'error',   'data' => false ]
     * 创  建 : 2018/06/12 21:48
     */
    public function loginSelect($openid)
    {
        // 获取数据库用户信息
        $userModel = new UserModel;
        // 加载配置项表信息
        $userModel->userInit();
        // 查询用户信息
        $user = $userModel->where('user_openid',$openid)->find();
        // 验证数据
        if(!$user){
            return returnData('error');
        }
        // 返回数据格式
        return returnData('success',$user);
    }

    /**
     * 名  称 : loginCreate()
     * 功  能 : 声明：添加用户数据
     * 变  量 : --------------------------------------
     * 输  入 : (string) $openid => '小程序用户openid';
     * 输  出 : [ 'msg' => 'success', 'data' => true ]
     * 输  出 : [ 'msg' => 'error',  'data' => false ]
     * 创  建 : 2018/06/12 21:48
     */
    public function loginCreate($openid)
    {
        // 实例化用户数据模型
        $userModel = new UserModel();
        // 加载配置项表信息
        $userModel->userInit();
        // 保存用户openid
        $userModel->user_openid = $openid;
        // 生成用户token身份标识
        $userModel->user_token = userToken();
        // 创建时间
        $userModel->user_time = time();
        // 保存数据库
        $res = $userModel->save();
        // 验证是否保存成功
        if(!$res){
            return returnData('error');
        }
        // 返回数据格式
        return returnData('success',true);
    }

    /**
     * 名  称 : loginAdminSelect()
     * 功  能 : 声明：获取用户数据
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : --------------------------------------
     * 创  建 : 2018/06/12 17:54
     */
    public function loginAdminSelect()
    {
        // 实例化用户数据模型
        $userModel = new UserModel();
        // 加载配置项表信息
        $userModel->userInit();
        // 查询用户信息
        $user = $userModel->where('user_id',1)->find();
        // 验证是否保存成功
        if(!$user){
            return returnData('error');
        }
        // 返回数据格式
        return returnData('success',$user);
    }
}