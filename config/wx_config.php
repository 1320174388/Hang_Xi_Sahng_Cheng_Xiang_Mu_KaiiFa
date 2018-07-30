<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  wx_config.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 16:57
 *  文件描述 :  模块配置文件
 *  历史记录 :  -----------------------
 */
return [
    // 小程序Appid
    'wx_AppID'     => 'wx8296c2f72540d393',
    // 小程序秘钥
    'wx_AppSecret' => 'c9f4a3b25d925674d1f1241b7578f839',
    // 获取openid地址
    'wx_LoginUrl'  => 'https://api.weixin.qq.com/sns/jscode2session',
    // 获取小程序全局的Access_Token地址URL
    'wx_Access_Token' => 'https://api.weixin.qq.com/cgi-bin/token',
    // 发送模版消息接口地址
    'wx_Push_Url' => 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send',
    // 用户咨询提醒 模板ID
    'PushAdmin' => 'cJQ6sV7SYRE4bY0j0JG8kdILFWt3__Hkps5NQsQGxwA',
    // 客服回复通知 模板ID
    'PushUser' => 'QMh7cE50hMe4YLgtGC-BUoXkQex2O7zv4Bq6lruWG70',
];