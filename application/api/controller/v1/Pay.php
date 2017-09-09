<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-30
 * Time: 11:33
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;


class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder'],
    ];

    //请求预订单
    public function getPreOrder($id = '')
    {
        (new IDMustBePostiveInt())->goCheck();

        $pay = new PayService($id);

        return $pay->pay();

    }

    /**
     * 微信异步通知频率 15/15/30/180/1800/1800/1800/1800/3600
     * post
     * 参数 xml
     *
     */
    public function receiveNotify()
    {
        $notify = new WxNotify();
        $notify->Handle();
    }


}