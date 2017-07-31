<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 20:56
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {

    public function goCheck(){
        //获取http传入参数
        $request = Request::instance();
        $params = $request->param();
        //参数校验
        $result = $this->batch()->check($params);
        if(!$result){
            $error = new ParameterException([
                'msg' => $this->error
            ]);
            throw $error;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value,$rule='',$data='',$field=''){
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function isNotEmpty($value,$rule='',$data='',$field=''){
        if(empty($value)){
            return false;
        }
        return true;
    }

}