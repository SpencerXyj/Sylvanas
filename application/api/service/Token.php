<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/8/2
 * Time: 22:20
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;

class Token
{
    public static function generateToken()
    {
        $randChars = getRandChars(32);
        $timeStamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');

        return md5($salt . $randChars . $timeStamp);
    }

    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }

    public static function getCurrentTokenVar($key)
    {
        //约定token保存在header中传递
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            //redis缓存将直接返回数组,所以添加数组判断
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('the value is not in token');
            }
        }
    }

    //用户及管理员
    public static function checkPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    //用户访问
    public static function checkExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
}