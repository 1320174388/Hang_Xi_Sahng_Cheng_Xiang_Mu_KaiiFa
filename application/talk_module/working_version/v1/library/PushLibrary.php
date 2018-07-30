<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  PushLibrary.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/25 18:37
 *  文件描述 :  推送模板消息
 *  历史记录 :  -----------------------
 */
namespace app\talk_module\working_version\v1\library;

class PushLibrary
{
    /**
     * 名  称 : sendTemplate()
     * 功  能 : 发送模板消息
     * 变  量 : --------------------------------------
     * 输  入 : (Array) $data = [
     *     'touser'           => '接收者（用户）的 openid',
     *     'template_id'      => '所需下发的模板消息的id',
     *     'page'             => '点击模板卡片后的跳转页面',
     *     'form_id'          => '表单提交场景下的formId',
     *     'data'             => [''=>''],
     * ];
     * 输  出 : ['msg'=>'success','data'=>true]
     * 创  建 : 2018/07/04 17:37
     */
    public function sendTemplate($data)
    {
        // 处理数据
        if(is_array($data)){
            $data = json_encode($data);
        }
        // 发送模板消息
        $url = config('wx_config.wx_Push_Url');
        $url.= '?access_token='.$this->accessToken();
        $wxData = $this->curlPost($url,$data);
        // 解析代码
        $wxArr = json_decode($wxData,true);
        // 验证数据
        if(!$wxArr) return returnData('error',$wxArr);
        if(($wxArr['errcode']==0)&&($wxArr['errmsg']=='ok')) {
            return returnData('success',true);
        }
        return returnData('error',json_decode($data));
    }

    /**
     * 名  称 : accessToken()
     * 功  能 : 获取AccessToken值
     * 创  建 : 2018/07/04 17:50
     */
    private function accessToken()
    {
        if(cache('access_token')){
            return cache('access_token');
        }
        // 获取Url地址
        $url = config('wx_config.wx_Access_Token');
        // 拼接URL地址
        $url.= '?grant_type=client_credential';
        $url.= '&appid='.config('wx_config.wx_AppID');
        $url.= '&secret='.config('wx_config.wx_AppSecret');
        // 发送UTL请求,获取accessToken值
        $res = $this->curlPost($url);
        $resArr = json_decode($res,true);
        $accessToken = $resArr['access_token'];
        // 保存access_token到缓存
        cache('access_token',$accessToken,3600);
        // 返回缓存内的access_token
        return cache('access_token');
    }

    /**
     * 名  称 : curlPost()
     * 功  能 : Curl请求发送数据
     * 创  建 : 2018/07/04 17:50
     */
    private function curlPost($push_url,$post_data=[])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $push_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}