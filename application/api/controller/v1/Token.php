<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/25
 * Time: 22:04
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token {
    public function getToken($code = "") {
        (new TokenGet())->goCheck();

        $userToken = new UserToken($code);

        $token = $userToken->get();

        return $token;
    }
}