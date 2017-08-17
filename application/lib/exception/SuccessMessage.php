<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-17
 * Time: 09:21
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $errorCode = 0;
    public $msg = "success";
}