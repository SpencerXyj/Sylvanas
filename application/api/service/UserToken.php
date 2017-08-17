<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/25
 * Time: 22:16
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;

class UserToken extends Token {
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $loginUrl;

    function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config("weixin.app_id");
        $this->wxAppSecret = config("weixin.app_secret");
        $this->loginUrl = sprintf(config("weixin.login_url"),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get() {
        $result = curl_get($this->loginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception("获取session_key及openID错误,微信内部异常");
        } else {
            $loginFail = array_key_exists("errcode", $wxResult);
            if ($loginFail) {
                self::processLoginError($wxResult);
            } else {
                $token = self::grantToken($wxResult);
                return $token;
            }
        }
    }

    private function grantToken($wxResult) {
        //获取openid
        $openid = $wxResult['openid'];
        //查询数据库openid是否存在
        $user = UserModel::getByOpenID($openid);
        //不存在插入新数据
        if (!$user) {
            $uid = self::newUser($openid);
        } else {
            $uid = $user['id'];
        }
        //生产令牌
        //存入缓存  key:token  value:$wxResult uid scope
        $cachedValue = self::prepareCachedValue($wxResult, $uid);
        $token = self::saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key, $value, $expire_in);
        if (!$result) {
            throw new TokenException([
                'msg' => 'cache error',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid, $scope = 16) {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = $scope;
        return $cachedValue;
    }

    private function newUser($openid) {
        $user = UserModel::create(['openid' => $openid]);
        return $user->id;
    }

    private function processLoginError($wxResult) {
        throw new WeChatException([
            'errorCode' => $wxResult['errcode'],
            'msg' => $wxResult['errmsg'],
        ]);
    }
}