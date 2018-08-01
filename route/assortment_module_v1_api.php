<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  assortment_module_v1_api.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/07/30 18:30
 *  文件描述 :  商品分类接口路由
 *  历史记录 :  -----------------------
 */
// +----------------------------------------------------------------------
// | 接口名称：添加商品分类
// | 路由地址：/v1/assortment_module/addGoodsClass
// | 请求类型：POST
// | 接收数据：`class_name`          分类名称      【必填】
// |           `class_img_url`       分类图片      【必填】
// |           `class_parent`        父类主键      【选填】
// | 路由功能：添加商品分类
// +----------------------------------------------------------------------
Route::post(
    'v1/assortment_module/addGoodsClass/:token',
    'assortment_module/v1.controller.IndexController/addGoodsClass'
)->middleware('Right_v3_IsAdmin');
// +----------------------------------------------------------------------
// | 接口名称：获取商品分类
// | 路由地址：/v1/assortment_module/getGoodsClass
// | 请求类型：GET
// | 接收数据：无
// | 路由功能：获取商品分类
// +----------------------------------------------------------------------
Route::get(
    'v1/assortment_module/getGoodsClass',
    'assortment_module/v1.controller.IndexController/getGoodsClass'
);
// +----------------------------------------------------------------------
// | 接口名称：修改商品分类
// | 路由地址：/v1/assortment_module/modifyGoodsClass
// | 请求类型：POST
// | 接收数据：`class_name`          分类名称      【必填】
// |           `class_img_url`       分类图片      【必填】
// |           `class_index`         分类主键      【必填】
// | 路由功能：修改商品分类
// +----------------------------------------------------------------------
Route::post(
    'v1/assortment_module/modifyGoodsClass/:token',
    'assortment_module/v1.controller.IndexController/modifyGoodsClass'
)->middleware('Right_v3_IsAdmin');
// +----------------------------------------------------------------------
// | 接口名称：删除商品分类
// | 路由地址：/v1/assortment_module/delectGoodsClass
// | 请求类型：GET
// | 接收数据：`class_index`         分类主键      【必填】
// | 路由功能：删除商品分类
// +----------------------------------------------------------------------
Route::get(
    'v1/assortment_module/delectGoodsClass/:token',
    'assortment_module/v1.controller.IndexController/delectGoodsClass'
)->middleware('Right_v3_IsAdmin');
// +----------------------------------------------------------------------
// | 接口名称：上传图片
// | 路由地址：/v1/assortment_module/uploadImage
// | 请求类型：POST
// | 路由功能：上传图片
// +----------------------------------------------------------------------
Route::post(
    'v1/assortment_module/uploadImage',
    'assortment_module/v1.controller.IndexController/uploadImage'
);