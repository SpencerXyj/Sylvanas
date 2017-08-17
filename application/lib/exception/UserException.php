<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-16
 * Time: 16:55
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $errorCode = 60000;
    public $msg = "user is not exist";
}