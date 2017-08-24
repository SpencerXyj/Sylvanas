<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-17
 * Time: 14:43
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    public function checkPrimaryScope()
    {
        TokenService::checkPrimaryScope();
    }

    public function checkExclusiveScope()
    {
        TokenService::checkExclusiveScope();
    }
}