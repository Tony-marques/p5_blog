<?php

namespace App\models;

class CommentModel extends AbstractModel
{

  public string $content;
  public string $published;
  public int $article_id;
  public int $user_id;


  public function __construct()
  {
    $this->table = "comments";
  }

  public function findByJoin(array $arr, $targetTable = null, $currentTableId = null, $targetTableId = null, bool $where = true)
  {
    $keys = [];
    $values = [];

    foreach ($arr as $key => $value) {
      $keys[] = "$key = ?";
      $values[] = $value;
    }

    $list_keys = implode(" AND ", $keys);

    if($where){
      $sql = "SELECT * FROM $this->table AS {$this->table[0]} INNER JOIN $targetTable AS $targetTable[0] ON {$this->table[0]}.$currentTableId = $targetTable[0].$targetTableId WHERE $list_keys";
    } else {
      $sql = "SELECT * FROM $this->table AS {$this->table[0]} INNER JOIN $targetTable AS $targetTable[0] ON {$this->table[0]}.$currentTableId = $targetTable[0].$targetTableId";
    }

    $stmt = $this->request($sql, $values);
    return $stmt->fetchAll();
  }

  public function findUserCommentArticle(array $arr)
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

      $sql = "SELECT '' as article, a.*, '' as user, u.* FROM $this->table AS {$this->table[0]} 
      INNER JOIN articles AS a 
      ON c.article_id = a.id 
      INNER JOIN users AS u 
      ON c.user_id = u.id 
      WHERE $list_keys";

    $stmt = $this->request($sql, $values);
    return $stmt->fetchAll();
  }


  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUserId($user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of article_id
   */
  public function getArticleId()
  {
    return $this->article_id;
  }

  /**
   * Set the value of article_id
   *
   * @return  self
   */
  public function setArticleId($article_id)
  {
    $this->article_id = $article_id;

    return $this;
  }

  /**
   * Get the value of content
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Set the value of content
   *
   * @return  self
   */
  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  /**
   * Get the value of published
   */
  public function getPublished()
  {
    return $this->published;
  }

  /**
   * Set the value of published
   *
   * @return  self
   */
  public function setPublished($published)
  {
    $this->published = $published;

    return $this;
  }
}
