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
    // $_dsn = "mysql:host=tonymapdb78totom.mysql.db;dbname=tonymapdb78totom;charset=utf8";
    try {
      parent::__construct($_dsn, "root", "");
      // parent::__construct($_dsn, "tonymapdb78totom", "MarquesTony78");
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
