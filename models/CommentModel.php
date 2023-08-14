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

  /**
   * Get the value of user_id
   */
  public function getUser_id()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of article_id
   */
  public function getArticle_id()
  {
    return $this->article_id;
  }

  /**
   * Set the value of article_id
   *
   * @return  self
   */
  public function setArticle_id($article_id)
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
