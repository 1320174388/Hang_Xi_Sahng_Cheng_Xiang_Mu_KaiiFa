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
    'wx_AppID'     => 'wx3a28f21a2448be0c',
    // 小程序秘钥
    'wx_AppSecret' => 'd7c173988bb49514923b9e837f49baff',
    // 获取openid地址
    'wx_LoginUrl'  => 'https://api.weixin.qq.com/sns/jscode2session',
    // 获取小程序全局的Access_Token地址URL
    'wx_Access_Token' => 'https://api.weixin.qq.com/cgi-bin/token',
    // 发送模版消息接口地址
    'wx_Push_Url' => 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send',
    // 用户咨询提醒 模板ID
    'PushAdmin' => '2TClx65vfpA8kqwEexw7J0fARev0bSm0Tvi3TQe4U_8',
    // 客服回复通知 模板ID
    'PushUser' => 'zUQUZD35j34JXneQA64RcRUGfT3Zex2tVnhOrddhGQA',
];