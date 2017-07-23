<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/20
 * Time: 21:32
 */

namespace app\api\controller\v1;

use app\api\model\Category as categoryModel;
use app\lib\exception\CategoryException;

class Category {

    /**
     * @return false|static[]
     * @throws CategoryException
     * @url category/all
     */
    public function getAllCategories() {

        $categories = categoryModel::all([],"img");
        if($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;

    }
}