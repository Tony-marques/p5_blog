<?php


namespace App\services;

use App\models\AbstractModel;

class UtilService
{

  public static function beautifulArray( $arr)
  {
    echo "<pre>";
    \print_r($arr);
    echo "</pre>";
  }
}
