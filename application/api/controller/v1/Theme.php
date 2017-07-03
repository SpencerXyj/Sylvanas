<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 20:01
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;

class Theme {
    /**
     * @url theme/?ids=id1,id2,id3....
     * return themes
     */
    public function getSimpleList($ids = ''){
         return (new IDCollection())->goCheck();
    }
}