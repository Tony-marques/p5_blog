<?php

namespace App\app;

use PDO;
use PDOException;

class Db extends PDO
{
  private static $instance;
  private function __construct()
  {
    $_dsn = "mysql:host=localhost;dbname=p5_blog;charset=utf8";
    try {
      parent::__construct($_dsn, "root", "");
      parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      $instance = new Db();
    }
    return $instance;
  }
}
