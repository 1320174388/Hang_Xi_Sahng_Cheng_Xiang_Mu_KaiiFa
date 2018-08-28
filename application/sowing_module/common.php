<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  common.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图模块公共何函数文件
 *  历史记录 :  -----------------------
 */

// +----------------------------------
// : 自定义函数区域
// +----------------------------------

/**
 * 名  称 : uniqidToken()
 * 功  能 : 生成当前时间微妙唯一Token标识字符串
 * 变  量 : --------------------------------------
 * 输  入 : --------------------------------------
 * 输  出 : 单一功能函数，只返回token字符串
 * 创  建 : 2018/08/09 18:33
 */
function uniqidToken()
{
    $str  = 'abcdefghijklmnopqrstuvwxyz';
    $str .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str .= '_123456789';

    $newStr = '';
    for( $i = 0; $i < 32; $i++) {
        $newStr .= $str[mt_rand(0,strlen($str)-1)];
    }
    $newStr .= time().mt_rand(100000,999999);

    return md5(uniqid().$newStr);
}

/**
 * 名  称 : imageUploads()
 * 功  能 : 处理文件上传函数
 * 变  量 : --------------------------------------
 * 输  入 : ( File ) $fileName  => '文件资源';
 * 输  入 : (String) $fileDir   => '文件保存路径'
 * 输  入 : (String) $fileUrl   => '文件保存后的URL地址'
 * 输  出 : ['success'=>'文件路径']
 * 创  建 : 2018/08/11 11:31
 */
function imageUploads($fileName,$fileDir,$fileUrl)
{
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file($fileName);
    // 判断是否上传图片
    if(!$file) return returnData(
        'error','没有上传图片'
    );
    // 移动到框架应用根目录/uploads/ 目录下 ，
    $info = $file->move($fileDir);
    // 返回上传失败获取错误信息
    if(!$info) return returnData(
        'error', $file->getError()
    );
    // 获取 20160820/42a79759f284b767dfcb2a0197904287.jpg
    return returnData(
        'success',
        $fileUrl.$info->getSaveName()
    );
}