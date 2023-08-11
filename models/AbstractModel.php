<?php

namespace App\models;

use App\app\Db;
use App\models\ArticleModel;

class AbstractModel
{

  protected $table;

  public function create(AbstractModel $model)
  {
    $fields = [];
    $separator = [];
    $values = [];

    foreach ($model as $key => $value) {
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

  public function findOne(int $id){
    $sql = "SELECT * FROM $this->table WHERE id = ?";
    $stmt = $this->request($sql, [$id]);
    return $stmt->fetch();
  }

  public function findByEmail(string $email){
    $sql = "SELECT * FROM $this->table WHERE email = ?";
    $stmt = $this->request($sql, [$email]);
    return $stmt->fetch();
  }

  public function findAll(){
    $sql = "SELECT * FROM $this->table";
    $stmt = $this->request($sql);
    return $stmt->fetchAll();
  }

  public function update(AbstractModel $model, int $id){
    // UPDATE SET title = ?, content = ? WHERE id = ?
    $fields = [];
    $values = [];

    foreach ($model as $key => $value) {
      if($key != "table"){
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

  public function delete(int $id){
    $sql = "DELETE FROM $this->table WHERE id = ?";
    return $this->request($sql, [$id]);
  }

  private function request(string $sql, array $params = [])
  {
    $db = Db::getInstance();
    if ($params != null) {
      // print_r($params);
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    } else {
      return $db->query($sql);
    }
  }
}
