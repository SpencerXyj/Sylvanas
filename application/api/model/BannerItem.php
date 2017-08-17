<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 20:35
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ["delete_time", "update_time", "img_id", "banner_id", "id"];

    public function img()
    {
        return $this->belongsTo("Image", "img_id", "id");
    }
}