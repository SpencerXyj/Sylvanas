<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 21:06
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate {
    protected $rule = [
        "id" => "require|isPositiveInteger",
    ];

    protected $message = [
        "id.require" => "id must be require"
    ];

    protected function isPositiveInteger($value,$rule='',$data='',$field=''){
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return $field." must be Positive Integer";
        }
    }
}