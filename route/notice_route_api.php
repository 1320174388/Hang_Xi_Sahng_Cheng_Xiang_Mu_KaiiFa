<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  noctice_route_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/06 14:25
 *  文件描述 :  公告控制器路由
 *  历史记录 :  -----------------------
 */

// -------------------------------------------
// : 前台接口，前台获取公告信息接口
// -------------------------------------------
/**
 * 路由名称: noctice_get
 * 传值方式: GET
 * 路由功能: 获取公告信息
 */
Route::get(
    'v1/noctice_module/noctice_get',
    'noctice_module/v1.controller.NocticeController/nocticeGet'
);

// +------------------------------------------------------
// : 后台接口：v1/noctice_module/ 中间件：Right_v3_IsAdmin
// +------------------------------------------------------

Route::group('v1/noctice_module/', function(){

    // ---- 商品管理 ----

    /**
     * 路由名称: noctice_put
     * 传值方式: PUT
     * 路由功能: 修改公共信息接口
     */
    Route::put(
        'noctice_put/:token',
        'noctice_module/v1.controller.NocticeController/nocticePut'
    );

})->middleware('Right_v3_IsAdmin');