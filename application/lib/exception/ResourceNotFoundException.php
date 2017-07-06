<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/4
 * Time: 22:47
 */

namespace app\lib\exception;


class ResourceNotFoundException extends BaseException {
    public $code = 404;
    public $errorCode = 10001;
    public $msg = "Resource Not Found";
}