<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/14
 * Time: 20:28
 */

namespace app\lib\exception;


class BannerMissException extends BaseException {
    public $code = 404;
    public $msg = "parameter error";
    public $errorCode = 40000;
}