<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 20:01
 */

namespace app\api\controller\v1;


use app\api\Model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme {
    /**
     * @url theme/?ids=id1,id2,id3....
     * return themes
     */
    public function getSimpleThemes($ids = '') {
        (new IDCollection())->goCheck();
        $ids = explode(",", $ids);
        $result = ThemeModel::getSimpleList($ids);
        if (!$result) {
            throw  new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id) {
        (new IDMustBePostiveInt())->goCheck();
        $result = ThemeModel::getComplexOneByID($id);
        if (!$result) {
            throw  new ThemeException();
        }
        return $result;
    }
}