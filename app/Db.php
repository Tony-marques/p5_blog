<?php

namespace App\app;

use PDO;
use PDOException;

class Db extends PDO
{
  private static $instance;
  private function __construct()
  {
    $_dsn = "mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_NAME"]};charset=utf8";
    try {
      parent::__construct($_dsn, $_ENV["DB_USERNAME"],$_ENV["DB_PASSWORD"]);
      parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      $instance = new Db();
    }
    return $instance;
  }
}


    // $_dsn = "mysql:host=tonymapdb78totom.mysql.db;dbname=tonymapdb78totom;charset=utf8";
      // parent::__construct($_dsn, "tonymapdb78totom", "MarquesTony78");
