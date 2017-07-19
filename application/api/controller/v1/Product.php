<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/19
 * Time: 22:18
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as productModel;
use app\lib\exception\ProductException;

class Product {
    public function getRecent($count = 15){
        (new Count())->goCheck();
        $product = productModel::getMostRecent($count);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
}