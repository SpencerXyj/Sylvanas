<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/8/2
 * Time: 22:20
 */

namespace app\api\service;


class Token {
    public static function generateToken() {
        $randChars = getRandChars(32);
        $timeStamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($salt . $randChars . $timeStamp);
    }
}