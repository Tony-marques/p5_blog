<?php

namespace App\services;

use DateTime;

class FormatDate
{

  public $dates = [];

  public function format($date)
  {
    $test = new DateTime($date);
    $newDate = $test->format("d/m/Y");
    $dates[] = $newDate;

    // print_r($dates);
    return $newDate;
  }
}
