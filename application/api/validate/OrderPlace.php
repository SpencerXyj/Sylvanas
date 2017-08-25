<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-24
 * Time: 11:46
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    //products []
    protected $rule = [
        'products' => 'checkProducts',
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count'      => 'require|isPositiveInteger',
    ];

    protected function checkProducts($values)
    {
        if (!is_array($values)) {
            throw new ParameterException(['msg' => 'products must be an array']);
        }

        if (empty($values)) {
            throw new ParameterException(['msg' => 'products can not be empty']);
        }

        foreach ($values as $key => $item) {
            $this->checkProduct($item);
        }

        return true;

    }

    private function checkProduct($values)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->batch()->check($values);
        if (!$result) {
            throw new ParameterException(['msg' => 'products params error']);
        }

        return $result;
    }
}
