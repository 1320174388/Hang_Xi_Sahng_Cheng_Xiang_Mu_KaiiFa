<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  login_route_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 15:04
 *  文件描述 :  模块路由地址
 *  历史记录 :  -----------------------
 */
/**
 * 传值方式：POST
 * 传值参数：[ :v => 版本号 ] [ :code => 用户临时登录凭证 ]
 * 路由功能：执行用户登录路由地址
 */
Route::post(
    ':v/login_module/login_init/:code',
    'login_module/:v.controller.LoginController/loginInit'
);
/**
 * 传值方式：GET
 * 传值参数：[ :v => 版本号 ] [ :token => 用户身份标识 ]
 * 路由功能：判断用是不是管理员
 */
Route::post(
    ':v/login_module/login_admin/:token',
    'login_module/:v.controller.LoginController/loginAdmin'
);