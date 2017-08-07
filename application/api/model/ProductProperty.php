<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/8/5
 * Time: 13:09
 */

namespace app\api\model;


class ProductProperty extends BaseModel {
    protected $hidden = ['delete_time', 'update_time', 'product_id'];
}