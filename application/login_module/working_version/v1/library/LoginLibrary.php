<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  LoginLibrary.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 19:27
 *  文件描述 :  处理用户登录类，获取用户openid
 *  历史记录 :  -----------------------
 */
namespace app\login_module\working_version\v1\library;

class LoginLibrary
{
    /**
     * 名  称 : userInfo()
     * 功  能 : 获取用户openid
     * 变  量 : --------------------------------------
     * 输  入 : (string) $code      => '用户临时登录code凭证';
     * 输  入 : (string) $appId     => '小程序AppId';
     * 输  入 : (string) $appSecret => '小程序AppSecret秘钥';
     * 输  出 : [ 'msg' => 'success', 'data' => $wxResult ]
     * 输  出 : [ 'msg' => 'error',  'data' => '请检查Code是否失效' ]
     * 创  建 : 2018/06/12 21:48
     */
    public function userInfo($code,$appId,$appSecret)
    {
        $wx_config = config('wx_config.');

        // 处理url字符串，发送指定数据
        $loginUrl  = $wx_config['wx_LoginUrl'];
        $loginUrl .= '?appid='.$appId;
        $loginUrl .= '&secret='.$appSecret;
        $loginUrl .= '&js_code='.$code;
        $loginUrl .= '&grant_type=authorization_code';

        // 获取请求接口返回的用户Openid数据
        $result = getCurl($loginUrl);
        $wxResult = json_decode($result['data'],true);

        // 验证返回数据格式是否正确
        if(empty($wxResult)){
            return returnData('error','请检查Code是否失效');
        }

        $loginFile = array_key_exists('errcode',$wxResult);

        if($loginFile){
            return returnData('error',$wxResult);
        }

        // 返回响应数据
        return returnData('success',$wxResult);
    }
}