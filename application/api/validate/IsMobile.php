<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-17
 * Time: 09:40
 */

namespace app\api\validate;


class IsMobile extends BaseValidate
{
    protected $rule = [
        "mobile" => "require|MustBeMobile",
    ];

    protected $message = [
        "mobile.require"      => "mobile must be require",
        "mobile.MustBeMobile" => "mobile is not in the correct format",
    ];
}