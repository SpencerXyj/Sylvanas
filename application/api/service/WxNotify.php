<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-07
 * Time: 15:36
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatus;
use think\Db;
use think\Exception;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        //检查库存,是否超卖
        //更新订单状态已支付
        //减库存
        //向微信返回处理成功消息  如果发生异常,返回处理失败
        /**
         * 微信回调信息
         * <xml>
         * <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
         * <attach><![CDATA[支付测试]]></attach>
         * <bank_type><![CDATA[CFT]]></bank_type>
         * <fee_type><![CDATA[CNY]]></fee_type>
         * <is_subscribe><![CDATA[Y]]></is_subscribe>
         * <mch_id><![CDATA[10000100]]></mch_id>
         * <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
         * <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
         * <out_trade_no><![CDATA[1409811653]]></out_trade_no>
         * <result_code><![CDATA[SUCCESS]]></result_code>
         * <return_code><![CDATA[SUCCESS]]></return_code>
         * <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
         * <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
         * <time_end><![CDATA[20140903131540]]></time_end>
         * <total_fee>1</total_fee>
         * <trade_type><![CDATA[JSAPI]]></trade_type>
         * <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
         * </xml>
         */
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            //开启事务 避免多次减库存
            Db::startTrans();
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)->lock(true)->find();
                if ($order['status'] == 1) {
                    $orderService = new OrderService();
                    $stockStatus = $orderService->checkOrderStock($orderNo);
                    if ($stockStatus['pass']) {
                        //更新订单状态
                        $this->updateOrderStatus($order->id, true);
                        //减库存
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                return true;
            } catch (Exception $e) {
                Log::error($e);
                Db::rollback();

                return false;
            }

        } else {
            //true or false  控制微信发送支付结果的异步请求
            //当支付失败时return true 表示微信不需要在调用支付后的回调接口了
            return true;
        }


    }

    private function updateOrderStatus($orderID, $success)
    {
        //已支付 库存充足 已支付 库存不足
        $status = $success ? OrderStatus::PAID : OrderStatus::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)->update(['status' => $status]);
    }

    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $key => $singlePStatusArray) {
            Product::where('id', '=', $singlePStatusArray['id'])->setDec('stock', $singlePStatusArray['count']);
        }
    }


}