<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/30
 * Time: 22:06
 */

namespace app\lib\exception;


class WebChatException extends BaseException {
    public $code = 400;
    public $errorCode = 999;
    public $msg = "微信服务器接口调用失败";
}