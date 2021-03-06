<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  collect_route_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/07 19:49
 *  文件描述 :  个人收藏模块路由文件
 *  历史记录 :  -----------------------
 */

// -------------------------------------------
// : 前台接口，用户处理商品收藏接口
// -------------------------------------------

/**
 * 路由名称: collect_post
 * 传值方式: POST
 * 路由功能: 添加个人收藏接口
 */
Route::post(
    'v1/collect_module/collect_post',
    'collect_module/v1.controller.CollectController/collectPost'
);
/**
 * 路由名称: collect_get
 * 传值方式: GET
 * 路由功能: 获取个人收藏商品数据接口
 */
Route::get(
    'v1/collect_module/collect_get',
    'collect_module/v1.controller.CollectController/collectGet'
);
/**
 * 路由名称: collect_isget
 * 传值方式: GET
 * 路由功能: 商品是否被收藏接口
 */
Route::get(
    'v1/collect_module/collect_isget',
    'collect_module/v1.controller.CollectController/collectIsGet'
);
/**
 * 路由名称: collect_delete
 * 传值方式: DELETE
 * 路由功能: 删除收藏商品
 */
Route::delete(
    'v1/collect_module/collect_delete',
    'collect_module/v1.controller.CollectController/collectDelete'
);
