<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/30
 * Time: 22:06
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $errorCode = 999;
    public $msg = "WeChat server interface call failed";
}