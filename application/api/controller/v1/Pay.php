<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-30
 * Time: 11:33
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder'],
    ];

    //请求预订单
    public function getPreOrder($id)
    {
        (new IDMustBePostiveInt())->goCheck();
    }


}