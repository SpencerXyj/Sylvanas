<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id'                    ,   'api/:version.Banner/getBanner', [], ['id' => '\d+']);

Route::get('api/:version/theme'                         ,   'api/:version.Theme/getSimpleThemes');
Route::get('api/:version/theme/:id'                     ,   'api/:version.Theme/getComplexOne', [], ['id' => '\d+']);

Route::group('api/:version/product/',function(){
    Route::get('recent'                                 ,   'api/:version.Product/getRecent');
    Route::get('by_category/:id'                        ,   'api/:version.Product/getAllInCategory');
    Route::get(':id'                                    ,   'api/:version.Product/getOne', [], ['id'=>'\d+']);
    Route::get('deleteOne/:id'                          ,   'api/:version.Product/deleteOne');
});

Route::get('api/:version/category/all'                  ,   'api/:version.Category/getAllCategories');

Route::post('api/:version/token/user'                   ,   'api/:version.Token/getToken');

Route::post('api/:version/address'                      ,   'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order'                        ,   'api/:version.Order/placeOrder');

Route::post('api/:version/order/pay/pre_pay'            ,   'api/:version.Pay/getPreOrder');
