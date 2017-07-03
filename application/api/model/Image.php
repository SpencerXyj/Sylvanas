<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 22:40
 */

namespace app\api\model;


class Image extends BaseModel {
    protected $hidden = ["delete_time", "update_time", "id", "from"];

    public function getUrlAttr($value,$data){
        return self::prefixImgUrl($value,$data);
    }
}