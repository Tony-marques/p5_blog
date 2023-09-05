<?php

namespace App\models;

use App\app\Db;

abstract class AbstractModel
{

  protected $table;

  /**
   * C of CRUD for Create
   */
  public function create()
  {
    $fields = [];
    $separator = [];
    $values = [];

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

  /**
   * R of CRUD for Read one
   */
  public function findOne(int $id)
  {
    $sql = "SELECT * FROM $this->table WHERE id = ?";
    $stmt = $this->request($sql, [$id]);
    return $stmt->fetch();
  }

  /**
   * R of CRUD for Read one by email
   */
  public function findByEmail(string $email)
  {
    $sql = "SELECT * FROM $this->table WHERE email = ?";
    $stmt = $this->request($sql, [$email]);
    return $stmt->fetch();
  }

  /**
   * R of CRUD for Read
   */
  public function findBy(array $arr, bool $join = false, $targetTable = null, $targetTableId = null)
  {
    $keys = [];
    $values = [];

    foreach ($arr as $key => $value) {
      $keys[] = "$key = ?";
      $values[] = $value;
    }

    $list_keys = implode(" AND ", $keys);

    if ($join) {
      $sql = "SELECT * FROM $this->table INNER JOIN $targetTable ON $this->table.id = $targetTable.$targetTableId  WHERE $list_keys";
      echo $sql;
      exit();
    } else {
      $sql = "SELECT * FROM $this->table WHERE $list_keys";
    }
    $stmt = $this->request($sql, $values);
    return $stmt->fetchAll();
  }

  /**
   * R of CRUD for Read
   */
  public function findAll($limit = null, $offset = 0, $orderBy = "DESC")
  {
    if ($limit !== null && $offset !== null) {
      $sql = "SELECT * FROM $this->table LIMIT $limit OFFSET $offset ORDER BY created_at $orderBy";
    } else {

      $sql = "SELECT * FROM $this->table ORDER BY created_at $orderBy";
    }
    $stmt = $this->request($sql);
    return $stmt->fetchAll();
  }

  /**
   * U of CRUD for Update
   */
  public function update($id)
  {
    $fields = [];
    $values = [];

    foreach ($this as $key => $value) {
      if ($key != "table") {
        $fields[] = "$key = ?";
        $values[] = $value;
      }
    };
    $values[] = $id;

    $list_fields = \implode(", ", $fields);

    $sql = "UPDATE $this->table SET $list_fields WHERE id = ?";

    return $this->request($sql, $values);
  }

  /**
   * D of CRUD for Delete
   */
  public function delete(int $id)
  {
    $sql = "DELETE FROM $this->table WHERE id = ?";
    return $this->request($sql, [$id]);
  }

  /**
   * Request for all method of CRUD
   */
  protected function request(string $sql, array $params = [])
  {
    $db = Db::getInstance();
    if ($params !== null) {
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    } else {
      return $db->query($sql);
    }
  }
}
