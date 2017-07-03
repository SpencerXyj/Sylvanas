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
        "id.require" => "id must be require",
        "id.isPositiveInteger" => "id must be Positive Integer"
    ];
}