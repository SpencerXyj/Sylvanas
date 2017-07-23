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
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\CategoryException;
use app\lib\exception\ProductException;

class Product {
    /**
     * @param int $count
     * @return mixed
     * @throws ProductException
     * @url product/recent
     */
    public function getRecent($count = 15){
        (new Count())->goCheck();
        $products = productModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws CategoryException
     * @url product/by_category/:id
     */
    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $products = productModel::getProductsByCategoryID($id);
        if($products->isEmpty()){
            throw new CategoryException();
        }
        return $products;
    }
}