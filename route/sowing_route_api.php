<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  sowing_route_api.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  路由文件
 *  历史记录 :  -----------------------
 */

/**
 * 传值方式 : GET
 * 路由功能 : 获取轮播图列表
 */
Route::get(
    ':v/sowing_module/sowing_route',
    'sowing_module/:v.controller.SowingController/sowingGet'
);

/**
 * 传值方式 : POST
 * 路由功能 : 添加轮播图
 */
Route::post(
    ':v/sowing_module/sowing_route/:token',
    'sowing_module/:v.controller.SowingController/sowingPost'
)->middleware('Right_v3_IsAdmin');