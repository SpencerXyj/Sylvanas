<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/19
 * Time: 22:48
 */

namespace app\lib\exception;


class ProductException extends BaseException {
    public $code = 404;
    public $errorCode = 20000;
    public $msg = "product Resource Not Found";
}