<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-17
 * Time: 10:14
 */

namespace app\api\controller\v1;


use app\api\validate\BaseValidate;

class Test
{
    public function test(){
        $validate = new BaseValidate();
        return $validate->getDataByRule(input("post."));
    }
}