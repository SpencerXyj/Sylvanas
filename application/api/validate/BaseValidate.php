<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 20:56
 */

namespace app\api\validate;


use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {

    public function goCheck(){
        //获取http传入参数
        $request = Request::instance();
        $params = $request->param();
        //参数校验
        $result = $this->check($params);
        if(!$result){
            $error = $this->error;
            throw new Exception($error);
        }else{
            return true;
        }
    }
}