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
/**
 * 路由名称: good_details
 * 传值方式: GET
 * 路由功能: 获取商品详情数据
 */
Route::get(
    'v1/good_module/good_details',
    'good_module/v1.controller.GoodController/goodGet'
);
/**
 * 路由名称: critic_get
 * 传值方式: GET
 * 路由功能: 获取商品评论信息接口
 */
Route::get(
    'v1/good_module/critic_get',
    'good_module/v1.controller.GoodController/goodCritic'
);
/**
 * 路由名称: good_get_list
 * 传值方式: GET
 * 路由功能: 获取商品列表数据
 */
Route::get(
    'v1/good_module/good_get_list',
    'good_module/v1.controller.GoodController/goodGetList'
);

// +------------------------------------------------------
// : 路由分组：v1/good_module/ 中间件：Right_v3_IsAdmin
// +------------------------------------------------------

Route::group('v1/good_module/', function(){

    // ---- 商品管理 ----

    /**
     * 路由名称: good_get_goodlist
     * 传值方式: GET
     * 路由功能: 添加商品信息接口
     */
    Route::get(
        'good_get_goodlist/:token',
        'good_module/v1.controller.GoodController/goodListGet'
    );

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
    /**
     * 路由名称: good_put
     * 传值方式: PUT
     * 路由功能: 修改商品信息接口
     */
    Route::put(
        'good_put/:token',
        'good_module/v1.controller.GoodController/goodPut'
    );
    /**
     * 路由名称: good_get
     * 传值方式: GET
     * 路由功能: 获取商品详情数据
     */
    Route::get(
        'good_get/:token',
        'good_module/v1.controller.GoodController/goodGet'
    );
    /**
     * 路由名称: good_critic
     * 传值方式: GET
     * 路由功能: 获取商品评论信息接口
     */
    Route::get(
        'good_critic/:token',
        'good_module/v1.controller.GoodController/goodCritic'
    );
    /**
     * 路由名称: good_critic_del
     * 传值方式: DELETE
     * 路由功能: 删除商品评论接口
     */
    Route::delete(
        'good_critic_del/:token',
        'good_module/v1.controller.GoodController/goodCriticDel'
    );
    /**
     * 路由名称: good_delete
     * 传值方式: DELETE
     * 路由功能: 删除商品数据接口
     */
    Route::delete(
        'good_delete/:token',
        'good_module/v1.controller.GoodController/goodDelete'
    );
    /**
     * 路由名称: good_get_list
     * 传值方式: GET
     * 路由功能: 获取商品列表数据
     */
    Route::get(
        'good_list/:token',
        'good_module/v1.controller.GoodController/goodGetList'
    );

})->middleware('Right_v3_IsAdmin');