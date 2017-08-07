<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/8/2
 * Time: 22:43
 */

namespace app\lib\exception;


class TokenException extends BaseException {
    public $code = 401;
    public $errorCode = 10001;
    public $msg = "token expired or invalid";
}