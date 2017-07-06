<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/6
 * Time: 21:06
 */

namespace app\lib\exception;


class ThemeException extends BaseException {
    public  $code = 404;
    public $errorCode = 10001;
    public $msg = "Themes not found";
}