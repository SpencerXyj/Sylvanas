<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/25
 * Time: 22:16
 */

namespace app\api\service;


use app\lib\exception\WebChatException;
use think\Exception;

class UserToken {
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
                self::grantToken($wxResult);
            }
        }
    }

    private function grantToken($wxResult){
        //获取openid
        $openid = $wxResult['openid'];
        //查询数据库openid是否存在
        //不存在插入新数据
        //生产令牌
    }

    private function processLoginError($wxResult) {
        throw new WebChatException([
            'errorCode' => $wxResult['errcode'],
            'msg' => $wxResult['errmsg'],
        ]);
    }
}