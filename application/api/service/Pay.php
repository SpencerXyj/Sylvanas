<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-30
 * Time: 13:56
 */

namespace app\api\service;


use app\lib\exception\OrderException;

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new OrderException(['msg' => 'order ID can not be empty']);
        }
        $this->orderID = $orderID;
    }

    protected function pay()
    {
        
    }
}