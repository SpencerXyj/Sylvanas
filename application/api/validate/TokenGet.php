<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/25
 * Time: 22:08
 */

namespace app\api\validate;


class TokenGet extends BaseValidate {
    protected $rule = [
        "code" => "require|isNotEmpty"
    ];

    protected $message = [
        "code.isNotEmpty" => "code can not empty"
    ];
}