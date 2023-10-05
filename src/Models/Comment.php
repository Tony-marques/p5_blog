<?php

namespace App\Models;

class Comment
{
    private $id;
    private ?string $content = null;
    private ?string $published = null;
    private ?int $articleId = null;
    private ?int $userId = null;
    private $createdAt;
    private User $user;
    private Article $article;

    public function __construct()
    {
//        $this->table = "comments";
    }

    /**
     * Get the value of user_id
     */
    public function getUserId():string
    {
        return $this->userId;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of article_id
     */
    public function getArticleId():string
    {
        return $this->articleId;
    }

    /**
     * Set the value of article_id
     *
     * @return  self
     */
    public function setArticleId($articleId): self
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent():string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of published
     */
    public function getPublished():string
    {
        return $this->published;
    }

    /**
     * Set the value of published
     *
     * @return  self
     */
    public function setPublished($published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser():User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle($article): self
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt():string
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }


}
