<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-29
 * Time: 15:35
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;
}