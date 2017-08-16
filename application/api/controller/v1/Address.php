<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-16
 * Time: 09:20
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;

class Address
{
    public function createOrUpdateAddress()
    {
        (new AddressNew())->goCheck();
        $uid = TokenService::getCurrentUid();
        

    }
}