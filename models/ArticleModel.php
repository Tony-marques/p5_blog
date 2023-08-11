<?php

namespace App\models;

use DateTime;

class ArticleModel extends AbstractModel
{
  protected string $title;
  protected string $content;
  protected string $author;
  private DateTime $created_at;
  private DateTime $updated_at;

  public function __construct()
  {
    $this->table = "articles";
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
   * Get the value of title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of updated_at
   */
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  /**
   * Set the value of updated_at
   *
   * @return  self
   */
  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;

    return $this;
  }

  /**
   * Get the value of created_at
   */
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */
  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of author
   */ 
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * Set the value of author
   *
   * @return  self
   */ 
  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }
}
