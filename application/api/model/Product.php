<?php
/**
 * Created by PhpStorm.
 * User: SpencerXie
 * Date: 2017/6/25
 * Time: 20:05
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'update_time',
        'delete_time',
        'create_time',
        'pivot',
        'from',
        'category_id',
    ];

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function property()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($name, $value)
    {
        return self::prefixImgUrl($name, $value);
    }

    public static function getMostRecent($count)
    {
        $product = self::limit($count)->order("create_time desc")->select();

        return $product;
    }

    public static function getProductsByCategoryID($CategoryID)
    {
        $products = self::where("category_id", "=", $CategoryID)->select();

        return $products;
    }

    public static function getProductDetail($id)
    {
        $product = self::with([
            'imgs' => function ($query) {
                $query->with('imageUrl')->order('order', 'asc');
            },
        ])->with('property')->find($id);

        return $product;
    }

}