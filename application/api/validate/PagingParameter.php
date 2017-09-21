<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-11
 * Time: 15:41
 */

namespace app\api\validate;


use think\Validate;

class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger',
    ];
    protected $message = [
        'page.isPositiveInteger' => 'page must be Positive Integer',
        'size.isPositiveInteger' => 'page must be Positive Integer',
    ];
}
