<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  common.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 17:18
 *  文件描述 :  模块公共文件
 *  历史记录 :  -----------------------
 */

/**
 * 名  称 : getCurl()
 * 功  能 : 获取用户openid/session_key
 * 变  量 : --------------------------------------
 * 输  入 : (string) $url       => '获取openid接口Url地址';
 * 输  出 : [ 'msg' => 'success','data' => $file_contents ]
 * 创  建 : 2018/06/13 13:23
 */
function getCurl($url,&$httpCode= 0) {

    // 创建一个新cURL资源
    $ch = curl_init();

    // 设置URL和相应的选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    // 不做证书效验，部署在Linux环境改为true
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);

    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);

    // 返回结果
    return returnData('success',$file_contents);

}

/**
 * 名  称 : userToken()
 * 功  能 : 生成Token标识字符串
 * 变  量 : --------------------------------------
 * 输  入 : --------------------------------------
 * 输  出 : 单一功能函数，只返回token字符串
 * 创  建 : 2018/06/13 15:09
 */
function userToken()
{
    $str  = 'abcdefghijklmnopqrstuvwxyz';
    $str .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str .= '_123456789';

    $newStr = '';
    for( $i = 0; $i < 32; $i++) {
        $newStr .= $str[mt_rand(0,strlen($str)-1)];
    }
    $newStr .= time().mt_rand(100000,999999);

    return md5($newStr);
}