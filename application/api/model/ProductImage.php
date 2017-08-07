<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/8/5
 * Time: 13:05
 */

namespace app\api\model;


class ProductImage extends BaseModel {
    protected $hidden = ['delete_time', 'img_id', 'product_id','id'];

    public function imageUrl() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}