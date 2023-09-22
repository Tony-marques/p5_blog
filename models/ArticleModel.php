<?php

namespace App\models;

use App\services\AbstractService;
use DateTime;

class ArticleModel extends AbstractService
{
    private int $id;

  private string $title;
  private string $content;
  private string $author;
  private string $createdAt;
  private string|\DateTimeImmutable $updatedAt;
  private int $userId;
  private $user;

  private $comment = [];







    // Hydratation de l'objet à partir d'un tableau associatif
    public function hydrate($donnees) {
        foreach ($donnees as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }

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
    return $this->updatedAt;
  }

  /**
   * Set the value of updated_at
   *
   * @return  self
   */
  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * Get the value of created_at
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;

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

  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->userId;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */
  public function setUserId($userId)
  {
    $this->userId = $userId;

    return $this;
  }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment( $comment): void
    {

        $this->comment[] = $comment;
//        print_r($this->comment);
    }


}
