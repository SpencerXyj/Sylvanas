<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-24
 * Time: 15:57
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;


class Order
{
    //客户端传递的订单商品列表
    protected $oProducts;

    //存于数据库的商品信息(包括库存量)
    protected $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products = $this->getProductByOrder($oProducts);
        $status = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;

            return $status;
        }
        //创建订单
        //订单快照
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;

        return $order;
    }

    private function createOrder($orderSnap)
    {
        //事务开启
        Db::startTrans();
        try {
            $orderNo = self::makeOrderNo();
            $order = new \app\api\model\Order();
            $order->order_no = $orderNo;
            $order->user_id = $this->uid;
            $order->total_price = $orderSnap['orderPrice'];
            $order->snap_img = $orderSnap['snapImg'];
            $order->snap_name = $orderSnap['snapName'];
            $order->total_count = $orderSnap['totalCount'];
            $order->snap_address = $orderSnap['snapAddress'];
            $order->snap_items = json_encode($orderSnap['pStatus']);

            $order->save();
            $orderID = $order->id;
            foreach ($this->oProducts as $key => &$p) {
                $p['order_id'] = $orderID;
            }

            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            //提交
            Db::commit();

            return [
                'order_id'    => $order->id,
                'order_no'    => $order->order_no,
                'create_time' => $order->create_time,
            ];
        } catch (Exception $e) {
            //回滚
            Db::rollback();
            throw $e;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($yCode) - 1;
        /*$orderSn = $yCode[intval(date('Y')) - '2017'] . strtoupper(dechex(date('m'))) . date('d') . substr(time(),
                -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));*/
        $orderSn = $yCode[rand(0, $max)] . strtoupper(dechex(date('m'))) . date('d') . substr(time(),
                -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

        return $orderSn;
    }

    private function snapOrder($status)
    {
        $snap = [
            'orderPrice'  => 0,
            'totalCount'  => 0,
            'pStatus'     => [],
            'snapAddress' => null,
            'snapName'    => '',
            'snapImg'     => '',
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }

        return $snap;

    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'errorCode' => 60001,
                'msg'       => 'user address is not found',
            ]);
        }

        return $userAddress->toArray();
    }

    private function getProductByOrder($oProducts)
    {
        $oPIDs = array_column($oProducts, 'protuct_id');
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();

        return $products;

    }

    private function getOrderStatus()
    {
        $status = [
            'pass'         => true,
            'orderPrice'   => 0,
            'pStatusArray' => [],
            'totalCount'   => 0,
        ];

        foreach ($this->oProducts as $key => $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];;
            array_push($status['pStatusArray'], $pStatus);
        }

        return $status;

    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pStatus = [
            'id'         => null,
            'haveStock'  => false,
            'count'      => 0,
            'name'       => '',
            'totalPrice' => 0,
        ];

        $product = false;

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $product = $products[$i];
            }
        }
        if (!$product) {
            throw new OrderException(['msg' => 'failed to create order,product id ' . $oPID . ' is not found']);
        } else {
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if (($product['stock'] - $oCount) >= 0) {
                $pStatus['haveStock'] = true;
            }
        }

        return $pStatus;
    }


}