<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/19
 * Time: 22:11
 */

namespace app\api\validate;


class Count extends BaseValidate {
    protected $rule = [
        "count" => "isPositiveInteger|between:1,15",
    ];
    protected $message = [
        "count.between"=>"count must between 1 - 15"
    ];
}