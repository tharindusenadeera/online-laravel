<?php

namespace App\Helper;

use Image;

/**
 *
 */
class ImageUpload
{

  public static function upload($image,$imageType = 'normal')
  {
    $imgName = uniqid().'.png';

    if ($imageType == 'base64') {
      $imgObj = Image::make($image);
    }else {
      $imgObj = Image::make($image->getRealPath());
    }

    //save original img
    $imgObj->save('../public/assets/uploads/products/'.$imgName);

    //save preview
    $imgObj->resize(500,750)->save('../public/assets/uploads/images/'.$imgName);

    //save thumbnail
    $imgObj->resize(125,185)->save('../public/assets/uploads/image/'.$imgName);

    return $imgName;
  }

  public static function uploadBase64($image)
  {
    $imgName = uniqid().'.png';

    $imgObj = Image::make($image);

    //save original img
    $imgObj->save('../public/assets/uploads/images/'.$imgName);

    return $imgName;
  }

}
