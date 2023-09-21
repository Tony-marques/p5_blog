<?php

namespace App\models;

use App\services\AbstractService;

class CommentModel extends AbstractService
{
    private $id;


    public function setId($id): void
    {
        $this->id = $id;
    }

    public string $content;
    public string $published;
    public int $articleId;
    public int $userId;

    private $createdAt;


    private $user;

    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }

    public function __construct()
    {
        $this->table = "comments";
    }


//  public function findUserCommentArticle(array $arr)
//  {
//    $keys = [];
//    $values = [];
//
//    foreach ($arr as $key => $value) {
//      $keys[] = "$key = ?";
//      $values[] = $value;
//    }
//
//    $list_keys = implode(" AND ", $keys);
//
//    $sql = "SELECT '' as article, a.*, '' as user, u.* FROM $this->table AS {$this->table[0]}
//      INNER JOIN articles AS a
//      ON c.article_id = a.id
//      INNER JOIN users AS u
//      ON c.user_id = u.id
//      WHERE $list_keys";
//
//    $stmt = $this->request($sql, $values);
//    return $stmt->fetchAll();
//  }

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
     * Get the value of article_id
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set the value of article_id
     *
     * @return  self
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

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

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
}
