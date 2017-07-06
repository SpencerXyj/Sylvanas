<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 20:05
 */

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'create_time', 'pivot'];

    public function getMainImgUrlAttr($name, $value) {
        return self::prefixImgUrl($name, $value);
    }

}