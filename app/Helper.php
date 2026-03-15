<?php

use App\CommonConst;

if(!function_exists('getFullImagePath')) {
    function getFullImagePath($id, $image) {
        $image_path = CommonConst::IMAGE_PATH . $id . '/' . $image;

        return $image_path;
    }
}

if(!function_exists('getThumbImagePath')) {
    function getThumbImagePath($id, $image) {
        $thumb_image_path = CommonConst::IMAGE_PATH . $id . '/' . CommonConst::THUMB_IMAGE_PATH . $image;

        return $thumb_image_path;
    }
}