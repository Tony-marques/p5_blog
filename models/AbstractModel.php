<?php

namespace App\models;

use App\app\Db;
use App\services\UtilService;

abstract class AbstractModel
{

  protected $table;

  public function create()
  {
    $fields = [];
    $separator = [];
    $values = [];
    // print_r($this);
    // exit;
    foreach ($this as $key => $value) {
      if ($key != "table") {
        $fields[] = "$key";
        $separator[] = "?";
        $values[] = "$value";
      }
    }

    $list_fields = implode(", ", $fields);
    $list_separator = implode(", ", $separator);

    $sql = "INSERT INTO $this->table($list_fields) VALUES($list_separator)";
    $this->request($sql, $values);
  }

  public function findOne(int $id)
  {
    $sql = "SELECT * FROM $this->table WHERE id = ?";
    $stmt = $this->request($sql, [$id]);
    return $stmt->fetch();
  }

  public function findByEmail(string $email)
  {
    $sql = "SELECT * FROM $this->table WHERE email = ?";
    $stmt = $this->request($sql, [$email]);
    return $stmt->fetch();
  }

  public function findBy(array $arr, bool $join = false, $targetTable = null, $targetTableId = null)
  {
    // Utils::beautifulArray($arr);
    // 
    $keys = [];
    $values = [];

    foreach ($arr as $key => $value) {
      $keys[] = "$key = ?";
      $values[] = $value;
    }

    $list_keys = implode(" AND ", $keys);

    // "SELECT * FROM articles INNER JOIN comments ON articles.id = comments.id WHERE $list_keys"

    if ($join) {
      $sql = "SELECT * FROM $this->table INNER JOIN $targetTable ON $this->table.id = $targetTable.$targetTableId  WHERE $list_keys";
      // echo $sql;
      // exit();
    } else {
      $sql = "SELECT * FROM $this->table WHERE $list_keys";
    }
    $stmt = $this->request($sql, $values);
    return $stmt->fetchAll();
  }

  public function findAll()
  {
    $sql = "SELECT * FROM $this->table";
    $stmt = $this->request($sql);
    return $stmt->fetchAll();
  }

  // public function update(AbstractModel $model, int $id)
  public function update($id)
  {
    // UPDATE SET title = ?, content = ? WHERE id = ?
    $fields = [];
    $values = [];

    foreach ($this as $key => $value) {
      if ($key != "table") {
        $fields[] = "$key = ?";
        $values[] = $value;
      }
    };
    $values[] = $id;

    // print_r($fields);
    // exit;

    $list_fields = \implode(", ", $fields);

    $sql = "UPDATE $this->table SET $list_fields WHERE id = ?";

    return $this->request($sql, $values);
  }

  public function delete(int $id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";
    return $this->request($sql, [$id]);
  }

  protected function request(string $sql, array $params = [])
  {
    $db = Db::getInstance();
    if ($params != null) {
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    } else {
      return $db->query($sql);
    }
  }
}
