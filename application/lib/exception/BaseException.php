<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/14
 * Time: 20:39
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception {
    public $code      = 400;
    public $msg       = "params error";
    public $errorCode = 10000;
    public function __construct($param=[]) {
        if(!is_array($param)){
            return false;
        }
        if(array_key_exists('code',$param)){
            $this->code = $param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
            $this->errorCode = $param['errorCode'];
        }
    }

}