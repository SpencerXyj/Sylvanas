<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/7/3
 * Time: 22:31
 */

namespace app\api\validate;


class IDCollection extends BaseValidate {
    protected $rule = [
        'ids' => 'require|CheckIds',
    ];

    protected $message = [
        'ids.require' => 'ids is require',
        'ids.CheckIds' => 'ids must be id1,id2,id3...',
    ];

    protected function CheckIds($value){
        $values = explode(',',$value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $key => $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}