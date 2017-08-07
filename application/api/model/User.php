<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/25
 * Time: 22:15
 */

namespace app\api\model;


class User extends BaseModel {
    public static function getByOpenID($openID) {
        $user = self::where('openid', '=', $openID)->find();
        return $user;
    }


}