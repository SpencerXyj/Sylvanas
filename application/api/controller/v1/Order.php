<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-23
 * Time: 10:57
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;

class Order extends BaseController
{
    // 用户提交商品信息

    // 查询相关商品库存

    // 有库存 订单存入数据库

    // 返回客户端可支付

    // 调用支付接口

    // 再次进行库存量检测

    // 调用支付接口

    // 支付返回的支付结果(异步),

    // 成功,检测库存量,库存量扣除 失败不减少酷库存量.返回支付结果到客户端

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $result = (new \app\api\service\Order())->place($uid, $products);

        return $result;
    }


}