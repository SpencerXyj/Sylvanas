<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-17
 * Time: 11:01
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'user_id', 'update_time', 'delete_time'];
}