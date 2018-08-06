<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  order_module_v1_api.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/03 10:30
 *  文件描述 :  订单路由文件
 *  历史记录 :  -----------------------
 */
Route::post(
    'v1/order_module/paymentOrder',
    'order_module/v1.controller.OrderController/paymentOrder'
);
Route::get(
    'v1/order_module/getUserOrderList',
    'order_module/v1.controller.OrderController/getUserOrderList'
);
Route::get(
    'v1/order_module/getAllOrderList',
    'order_module/v1.controller.OrderController/getAllOrderList'
);
Route::get(
    'v1/order_module/getOrderDetails',
    'order_module/v1.controller.OrderController/getOrderDetails'
);
Route::get(
    'v1/order_module/setOrderState',
    'order_module/v1.controller.OrderController/setOrderState'
);
Route::post(
    'v1/order_module/orderDoodsComment',
    'order_module/v1.controller.OrderController/orderDoodsComment'
);
