<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  good_route_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/31 10:07
 *  文件描述 :  商品模块路由地址
 *  历史记录 :  -----------------------
 */

// -------------------------------------------
// : 前台接口，用户提问问题接口，自动回复信息接口
// -------------------------------------------


// +------------------------------------------------------
// : 路由分组：v1/good_module/ 中间件：Right_v3_IsAdmin
// +------------------------------------------------------

Route::group('v1/good_module/', function(){

    // ---- 添加商品 ----

    /**
     * 路由名称: good_post
     * 传值方式: POST
     * 路由功能: 添加商品信息接口
     */
    Route::post(
        'good_post/:token',
        'good_module/v1.controller.GoodController/goodPost'
    );
    /**
     * 路由名称: good_image_post
     * 传值方式: POST
     * 路由功能: 设置商品图片接口
     */
    Route::post(
        'good_image_post/:token',
        'good_module/v1.controller.GoodController/goodImagePost'
    );

})->middleware('Right_v3_IsAdmin');