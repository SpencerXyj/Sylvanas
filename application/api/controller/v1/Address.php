<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-16
 * Time: 09:20
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress'],
    ];

    public function createOrUpdateAddress()
    {
        //参数校验
        $validate = new AddressNew();
        $validate->goCheck();
        //获取token保存的uid
        $uid = TokenService::getCurrentUid();
        //查询user是否存在
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $userAddress = $user->address;
        $addressData = $validate->getDataByRule();
        //不存在新增  存在更新
        if (!$userAddress) {
            $user->address()->save($addressData);
        } else {
            $user->address->save($addressData);
        }
        throw new SuccessMessage();
    }
}