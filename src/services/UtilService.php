<?php


namespace services;

use App\models\AbstractModel;

class UtilService
{

  public static function beautifulArray( $arr)
  {
    echo "<pre>";
    var_dump($arr);
    echo "</pre>";
    exit;
  }
}
