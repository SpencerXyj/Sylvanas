<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-21
 * Time: 15:08
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $errorCode = 10001;
    public $msg = "insufficient privilege";
}