<?php


namespace App\Services;


class UtilService
{

  public static function beautifulArray( $arr):void
  {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    exit;
  }
}
