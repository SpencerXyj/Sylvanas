<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-25
 * Time: 14:15
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $errorCode = 80000;
    public $msg = "order does not exist";
}