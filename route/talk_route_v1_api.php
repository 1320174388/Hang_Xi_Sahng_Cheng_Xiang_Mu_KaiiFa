<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  talk_route_v1_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/29 17:20
 *  文件描述 :  客服功能模块接口路由
 *  历史记录 :  -----------------------
 */

// -------------------------------------------
// : 前台接口，用户提问问题接口，自动回复信息接口
// -------------------------------------------

Route::group('v1/talk_module/', function(){

    // ---- 自动回复 ----

    /**
     * 路由名称: replys_route
     * 传值方式: POST
     * 路由功能: 添加自动回复信息
     */
    Route::get(
        'replys_list',
        'talk_module/v1.controller.ReplyController/replyGet'
    );

    // ---- 用户留言 ----

    /**
     * 路由名称: info_post
     * 传值方式: POST
     * 路由功能: 添加提问信息
     */
    Route::post(
        'info_post',
        'talk_module/v1.controller.InfoController/infoPost'
    );
    /**
     * 路由名称: info_get
     * 传值方式: GET
     * 路由功能: 获取提问信息
     */
    Route::get(
        'info_get',
        'talk_module/v1.controller.InfoController/infoGet'
    );
    /**
     * 路由名称: info_details
     * 传值方式: GET
     * 路由功能: 获取提问信息详情
     */
    Route::get(
        'info_details',
        'talk_module/v1.controller.InfoController/infoDetails'
    );
    /**
     * 路由名称: info_do_post
     * 传值方式: POST
     * 路由功能: 用户继续提问接口
     */
    Route::post(
        'info_do_post',
        'talk_module/v1.controller.InfoController/infoDoPost'
    );

});


// +------------------------------------------------------
// : 路由分组：v1/talk_module/ 中间件：Right_v3_IsAdmin
// +------------------------------------------------------
Route::group('v1/talk_module/', function(){

    // ---- 用户信息 ----

    /**
     * 路由名称: user_route
     * 传值方式: GET
     * 路由功能: 获取所有用户信息
     */
    Route::get(
        'user_route/:token',
        'talk_module/v1.controller.InfoController/userGet'
    );

    // ---- 回复信息 ----

    /**
     * 路由名称: admin_reply
     * 传值方式: POST
     * 路由功能: 客服回复用户信息接口
     */
    Route::post(
        'admin_reply/:token',
        'talk_module/v1.controller.InfoController/adminReply'
    );

    // ---- 收集管理id ----

    /**
     * 路由名称: admin_route
     * 传值方式: POST
     * 路由功能: 收集管理id
     */
    Route::post(
        'admin_route/:token',
        'talk_module/v1.controller.InfoController/adminPost'
    );

    // ---- 自动回复 ----

    /**
     * 路由名称: replys_route
     * 传值方式: POST
     * 路由功能: 添加自动回复信息
     */
    Route::post(
        'replys_route/:token',
        'talk_module/v1.controller.ReplyController/replyPost'
    );
    /**
     * 路由名称: replys_route
     * 传值方式: GET
     * 路由功能: 获取自动回复信息
     */
    Route::get(
        'replys_route/:token',
        'talk_module/v1.controller.ReplyController/replyGet'
    );
    /**
     * 路由名称: replys_route
     * 传值方式: PUT
     * 路由功能: 修改自动回复信息
     */
    Route::put(
        'replys_route/:token',
        'talk_module/v1.controller.ReplyController/replyPut'
    );
    /**
     * 路由名称: replys_route
     * 传值方式: DELETE
     * 路由功能: 删除自动回复信息
     */
    Route::delete(
        'replys_route/:token',
        'talk_module/v1.controller.ReplyController/replyDel'
    );

})->middleware('Right_v3_IsAdmin');

