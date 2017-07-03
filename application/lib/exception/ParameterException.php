<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/3
 * Time: 23:03
 */

namespace app\lib\exception;


class ParameterException extends BaseException {
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}