<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-24
 * Time: 15:57
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

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
        ];

        foreach ($this->oProducts as $key => $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);

        }

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