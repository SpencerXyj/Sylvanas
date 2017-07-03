<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 20:02
 */

namespace app\api\model;


class Theme extends BaseModel {
    public function topicImg(){
        return $this->belongsTo("Image","topic_img_id","id");
    }
}