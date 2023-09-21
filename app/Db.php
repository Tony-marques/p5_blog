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
      parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      return;
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
