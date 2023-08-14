<?php


namespace App\services;

use App\models\AbstractModel;

class Utils
{

  public static function beautifulArray(array|AbstractModel $arr)
  {
    echo "<pre>";
    var_dump($arr);
    echo "</pre>";
    exit();
  }
}
