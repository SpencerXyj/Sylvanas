<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/5/3
 * Time: 23:44
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use app\lib\exception\ResourceNotFoundException;

class Banner {

    public function getBanner($id){
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }

    public function getIPWhiteList(){
        throw new ResourceNotFoundException([
            "msg" => "IP White List Resource Not Found",
        ]);
    }
}