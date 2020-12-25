<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    protected static $imageDir = 'storage\\images\\';

    public static $imageGlue = "\\";

    public static function saveImage($image) {
        $fileName = uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(Image::$imageDir, $fileName);
        return $fileName;
    }

    public static function saveAll($arr) {
        $images = new ArrayObject();
        foreach ($arr as $image) {
            $images->append(Image::saveImage($image));
        }
        return implode(Image::$imageGlue, $images->getArrayCopy());
    }

    public static function deleteImage($image) {
        if (is_file(Image::$imageDir.$image)) {
            unlink(Image::$imageDir.$image);
        }
    }

    public static function deleteAll($images) {
        $arr = explode(Image::$imageGlue, $images);
        foreach ($arr as $img) {
            Image::deleteImage($img);
        }
    }

}
