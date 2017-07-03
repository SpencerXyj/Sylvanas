<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 17:41
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model {
    //读取器 url拼接
    protected function prefixImgUrl($value, $data) {
        if ($data['from'] == 1) {
            $img_prefix = config("setting.img_prefix");
            $value = $img_prefix . $value;

        }
        return $value;
    }
}