<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/23
 * Time: 22:16
 */

namespace app\lib\exception;


class CategoryException extends BaseException {
    public $code = 404;
    public $msg = "Category not found";
    public $errorCode = 50000;
}