<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/14
 * Time: 20:52
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle {
    private $code;
    private $msg;
    private $errorCode;
    public function render(\Exception $e) {
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg  = $e->msg;
            $this->errorCode  = $e->errorCode;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }

            $this->code = 500;
            $this->msg  = "sorry , an unknow error!";
            $this->errorCode  = 999;
            self::recordErrorLog($e);
        }
        $request = Request::instance();
        $result = [
            "errorCode" => $this->errorCode,
            "msg" => $this->msg,
            "url" => $request->url(),
        ];
        return json($result,$this->code);
    }

    private function recordErrorLog($e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}