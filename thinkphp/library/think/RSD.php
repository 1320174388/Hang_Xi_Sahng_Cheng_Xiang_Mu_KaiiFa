<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  RSD.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/15 17:01
 *  文件描述 :  Wx_小程序：返回数据函数类
 *  历史记录 :  -----------------------
 */
namespace think;
class RSD
{
    /**
     * 名 称 : $rsdConfig
     * 功 能 : 返回数据配置信息
     * 创 建 : 2018/08/15 17:02
     */
    private static $rsdConfig = array(
        // Service逻辑层状态
        'Service'  => 'S',
        // Library自定义类状态
        'Lirbrary' => 'L',
        // Dao数据层状态
        'Dao'      => 'D' ,
        // Model层状态
        'Model'    => 'M',
    );

    /**
     * 名 称 : __construct()
     * 功 能 : 定义配置信息数据
     * 创 建 : 2018/08/15 17:05
     */
    private function __construct()
    {
        // TODO: 禁止外部实例化
    }

    /**
     * 名 称 : __clone()
     * 功 能 : 禁止外部克隆该实例
     * 创 建 : 2018/08/15 17:07
     */
    private function __clone()
    {
        // TODO: 禁止外部克隆该实例
    }

    /**
     * 名  称 : returnData()
     * 功  能 : 返回函数数据
     * 输  入 : (Array)  $Array  => '需要验证数据';
     * 输  入 : (String) $type   => '验证数据类型';
     * 输  入 : (String) $String => '返回提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    public static function wxReponse($Array,$type,$String='')
    {
        // 验证Service层数据
        if($type==self::$rsdConfig['Service'])
        {
            return self::serviceValidate($Array,$String);
        }
        // 验证Library层数据
        if($type==self::$rsdConfig['Lirbrary'])
        {
            return self::libraryValidate($Array,$String);
        }
        // 验证Dao层数据
        if($type==self::$rsdConfig['Dao'])
        {
            return self::daoValidate($Array,$String);
        }
        // 验证Model层数据
        if($type==self::$rsdConfig['Model'])
        {
            return self::modelValidate($Array,$String);
        }
    }

    /**
     * 名  称 : serviceValidate()
     * 功  能 : 验证Service层数据
     * 输  入 : (Array) $Array   => '需要验证数据';
     * 输  入 : (String) $String => '返回提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function serviceValidate($Array,$String='')
    {
        // 返回正确数据
        if($Array['msg']=='error')
        {
            if(!empty($String)){
                return self::returnJson(
                    1, $String
                );
            }
            return self::returnJson(
                1, $Array['data']
            );
        }
        // 返回错误数据
        if($Array['msg']=='success')
        {
            if( $String === '请求成功' )
            {
                return self::returnJson(
                    0, $String, $Array['data']
                );
            }
            return self::returnJson(
                0, $Array['data'], true
            );
        }
        // 返回异常数据
        return self::returnJson(
            2,
            'Service逻辑返回数据异常'
        );
    }

    /**
     * 名  称 : libraryValidate()
     * 功  能 : 验证Library层数据
     * 功  能 : 验证Library层数据
     * 输  入 : (Array) $Array   => '需要验证数据';
     * 输  入 : (String) $String => '返回提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function libraryValidate($Array,$String='')
    {
        // 返回错误格式信息
        if($Array['msg']=='error')
        {
            return self::returnData(
                $Array['msg'], $String
            );
        }
        // 返回正确格式信息
        if($Array['msg']=='success')
        {
            return self::returnData(
                $Array['msg'], $Array['data']
            );
        }
        // 返回异常格式信息
        return self::returnData(
            'error', 'Library类返回数据异常'
        );
    }

    /**
     * 名  称 : daoValidate()
     * 功  能 : 验证Dao层数据
     * 输  入 : (Array) $Array   => '需要验证数据';
     * 输  入 : (String) $String => '返回提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function daoValidate($Array,$String='')
    {
        // 返回错误格式信息
        if($Array['msg']=='error')
        {
            return self::returnData(
                $Array['msg'], $String
            );
        }
        // 返回正确格式信息
        if($Array['msg']=='success')
        {
            return self::returnData(
                $Array['msg'], $Array['data']
            );
        }
        // 返回异常格式信息
        return self::returnData(
            'error', 'Dao数据层返回参数异常'
        );
    }

    /**
     * 名  称 : modelValidate()
     * 功  能 : 验证Model层数据
     * 输  入 : (Array) $Array   => '需要验证数据';
     * 输  入 : (String) $String => '返回提示信息';
     * 创  建 : 2018/08/15 17:10
     */
    private static function modelValidate($Array,$String)
    {
        // 返回错误格式信息
        if(!$Array) return self::returnData(
            'error', $String
        );

        // 返回错误格式信息
        if($Array) return self::returnData(
            'success', $Array['data']
        );
    }

    /**
     * 名  称 : returnData()
     * 功  能 : 返回函数数据
     * 输  入 : (string) $msg  => 'success'/'error'
     * 输  入 : ( data ) $data => '任意数据格式内容'
     * 输  出 : [ 'msg' => 'success', 'data' => $data ]
     * 输  出 : [ 'msg' => 'error',  'data' => $data ]
     * 创  建 : 2018/08/15 17:10
     */
    private static function returnData($msg,$data = false)
    {
        return [ 'msg'=>$msg, 'data'=>$data ];
    }

    /**
     * 名  称 : returnJson()
     * 功  能 : 返回json数据
     * 输  入 : (int)    $errNum  => '返回状态编号';
     * 输  入 : (string) $retMsg  => '提示信息'
     * 输  入 : (data)   $retData => '任意数据格式内容'
     * 输  出 : {"errNum":0,"retMsg":"提示信息","retData":"返回数据"}
     * 创  建 : 2018/08/15 17:13
     */
    private static function returnJson($errNum,$retMsg,$retData=false)
    {
        return json_encode([
            'errNum'  => $errNum,
            'retMsg'  => $retMsg,
            'retData' => $retData
        ], 320);
    }
}