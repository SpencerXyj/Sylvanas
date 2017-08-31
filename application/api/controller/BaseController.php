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
    // >=USER
    public function checkPrimaryScope()
    {
        TokenService::checkPrimaryScope();
    }

    // ==USER
    public function checkExclusiveScope()
    {
        TokenService::checkExclusiveScope();
    }
}