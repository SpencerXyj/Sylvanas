<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-30
 * Time: 13:56
 */

namespace app\api\service;


use app\lib\enum\OrderStatus;
use app\lib\exception\OrderException;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\exception\TokenException;
use think\Log;
use think\Loader;


Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

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

    public function pay()
    {
        $orderService = new OrderService();
        $this->checkOrderValid();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }

        return $this->makeWXPreOrder($status['orderPrice']);

    }

    private function makeWXPreOrder($totalPrice)
    {
        $openID = Token::getCurrentTokenVar('openid');
        if (!$openID) {
            throw new TokenException();
        }

        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOpenid($openID);
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody("零食商贩");
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));

        $rawValues = $this->getPayRawValues($wxOrderData);

        return $rawValues;
    }

    //调用预订单接口
    private function getPayRawValues($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if (!$wxOrder['return_code'] != 'SUCCESS' || !$wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('get prePay info fail', 'error');
        }

        //处理 prepay_id
        $this->recordPreOrder($wxOrder);
        $rawValues = $this->sing($wxOrder);

        return $rawValues;
    }

    //生成签名
    private function sing($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay;
        $jsApiPayData->SetAppid(config('weixin.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $jsApiPayData->SetNonceStr(getRandChars(32));
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $jsApiPayData->SetPaySign($sign);
        $rawValues = $jsApiPayData->GetValues();
        unset($rawValues['appId']);

        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('id', '=', $this->orderID)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        //订单是否存在
        $order = OrderModel::get($this->orderID);
        if (!$order) {
            throw new OrderException();
        }
        //用户是否一致
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'errorCode' => 10003,
                'msg'       => 'user and order do not match',
            ]);
        }
        //是否已支付
        if ($order['status'] != OrderStatus::UNPAID) {
            throw new OrderException([
                'code'      => 400,
                'errorCode' => 80003,
                'msg'       => 'this order has been paid',
            ]);
        }
        $this->orderNO = $order->order_no;

        return true;
    }
}