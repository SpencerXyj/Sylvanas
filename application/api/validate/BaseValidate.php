<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/12
 * Time: 20:56
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{

    public function goCheck()
    {
        //获取http传入参数
        $request = Request::instance();
        $params = $request->param();
        //参数校验
        $result = $this->batch()->check($params);
        if (!$result) {
            $error = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $error;
        } else {
            return true;
        }
    }

    public function getDataByRule()
    {
        //获取http传入参数
        $request = Request::instance();
        $arrays = $request->param();
        if (array_key_exists('uid', $arrays) || array_key_exists('user_id', $arrays)) {
            throw new ParameterException(['msg' => 'parameter contains illegal arguments']);
        }

        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }

        return $newArray;

    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return false;
        }

        return true;
    }

    /**手机号验证
     * 移动：134、135、136、137、138、139、150、151、152、157、158、159、182、183、184、187、188、178(4G)、147(上网卡)；
     *联通：130、131、132、155、156、185、186、176(4G)、145(上网卡)；
     *电信：133、153、180、181、189 、177(4G)；
     *虚拟运营商：170
     *卫星通信：1349
     */
    protected function MustBeMobile($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && (preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#',
                $value))) {
            return true;
        }

        return 'mobile is not in the correct format';
    }


}