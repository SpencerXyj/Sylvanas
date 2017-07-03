<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 20:27
 */

namespace app\api\model;


class Banner extends BaseModel {

    protected $hidden = ["delete_time","update_time"];
    //关联模型 关联模型,关联模型外键,当前模型主键
    public function items(){
        return $this->hasMany("BannerItem","banner_id","id");
    }

    public static function getBannerByID($id){
        $banner = self::with(["items","items.img"])->find($id);
        return $banner;
    }
}