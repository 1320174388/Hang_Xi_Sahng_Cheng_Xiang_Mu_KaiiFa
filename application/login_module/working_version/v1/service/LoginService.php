<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  LoginService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 17:24
 *  文件描述 :  处理用户登录的业务逻辑
 *  历史记录 :  -----------------------
 */
namespace app\login_module\working_version\v1\service;
use app\login_module\working_version\v1\dao\LoginDao;
use app\login_module\working_version\v1\library\LoginLibrary;

class LoginService
{
    /**
     * 名  称 : userInit()
     * 功  能 : 处理用户登录认证，返回用户token身份标识
     * 变  量 : --------------------------------------
     * 输  入 : (string) $code      => '用户临时登录code凭证';
     * 输  入 : (string) $appId     => '小程序AppId';
     * 输  入 : (string) $appSecret => '小程序AppSecret秘钥';
     * 输  出 : [ 'msg' => 'success','data' => [ 'token'=>$token ] ]
     * 输  出 : [ 'msg' => 'error',  'data' => $data['data'] ]
     * 创  建 : 2018/06/12 21:50
     */
    public function userInit($code,$appId,$appSecret)
    {
        // 引入LoginLibrary类库文件
        $data = (new LoginLibrary)->userInfo($code,$appId,$appSecret);
        // 验证LoginLibrary返回数据
        if($data['msg']=='error'){
            return returnData('error',$data['data']);
        }

        // 处理用户openid数据，获取token
        $userTokenArr = $this->getToken($data['data']);
        // 验证getToken返回数据
        if($userTokenArr['msg']=='error'){
            return returnData('error','登录失败');
        }
        $token = $userTokenArr['data'];

        // 返回数据格式
        return returnData('success',['token'=>$token]);
    }

    /**
     * 名  称 : getToken()
     * 功  能 : 保存用户openid，返回token用户身份标识
     * 变  量 : --------------------------------------
     * 输  入 : (array) $wxResult  => '用户openid/session_key信息';
     * 输  出 : [ 'msg' => 'success','data' => [ 'token'=>$token ] ]
     * 输  出 : [ 'msg' => 'error',  'data' => false ]
     * 创  建 : 2018/06/13 14:29
     */
    private function getToken($wxResult)
    {
        // 获取用户OpenId信息
        $openid = $wxResult['openid'];
        // 查看数据库是否有用户openID
        $userInfo = (new LoginDao())->loginSelect($openid);

        // 验证返回数据格式
        if( $userInfo['msg']=='error' ) {
            // 添加用户openid到数据库
            $res = (new LoginDao)->loginCreate($openid);
            // 验证数据格式
            if($res['msg']=='error'){
                return returnData('error');
            }
            // 再次获取用户数据
            $userInfo = (new LoginDao())->loginSelect($openid);
        }
        // 获取用户Token标识
        $token = $userInfo['data']->user_token;
        // 返回数据格式
        return returnData('success',$token);
    }

    /**
     * 名  称 : userAdmin()
     * 功  能 : 判断用户是不是管理员
     * 变  量 : --------------------------------------
     * 输  入 : (string) $token => '用户身份标标识';
     * 输  出 : [ 'msg' => 'success',true]
     * 输  出 : [ 'msg' => 'error', false]
     * 创  建 : 2018/06/13 14:29
     */
    public function userAdmin($token)
    {
        // 查看数据库是否有用户openID
        $userInfo = (new LoginDao())->loginAdminSelect();

        // 验证返回数据格式
        if( $userInfo['msg']=='error' ) {
            return returnData('error','没有最高管理员');
        }

        // 判断用户是不是最高管理员
        if ($token!=$userInfo['data']['user_token']) {
            return returnData('error');
        }

        // 返回数据格式
        return returnData('success',true);
    }
}