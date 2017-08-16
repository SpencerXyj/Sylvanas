<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-16
 * Time: 09:36
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name'     => 'require|isNotEmpty',
        'mobile'   => 'require|isNotEmpty',
        'province' => 'require|isNotEmpty',
        'city'     => 'require|isNotEmpty',
        'country'  => 'require|isNotEmpty',
        'detail'   => 'require|isNotEmpty',
    ];

    protected $message = [
        'name.require'        => 'name is require',
        'name.isNotEmpty'     => 'name is not empty',
        'mobile.require'      => 'mobile is require',
        'mobile.isNotEmpty'   => 'mobile is not empty',
        'province.require'    => 'province is require',
        'province.isNotEmpty' => 'province is not empty',
        'city.require'        => 'city is require',
        'city.isNotEmpty'     => 'city is not empty',
        'country.require'     => 'country is require',
        'country.isNotEmpty'  => 'country is not empty',
        'detail.require'      => 'detail is require',
        'detail.isNotEmpty'   => 'detail is not empty',
    ];
}