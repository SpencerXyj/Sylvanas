<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/20
 * Time: 21:33
 */

namespace app\api\model;


class Category extends BaseModel {

    protected $hidden = ["delete_time","update_time","topic_img_id"];

    public function img(){
        return $this->belongsTo("Image","topic_img_id","id");
    }
}