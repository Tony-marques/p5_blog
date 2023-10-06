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

    /**
     * Get the value of user_id
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set the value of user_id
     *
     * @param int $userId
     * @return  self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of article_id
     */
    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    /**
     * Set the value of article_id
     *
     * @param int $articleId
     * @return  self
     */
    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param string $content
     * @return  self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of published
     */
    public function getPublished(): string
    {
        return $this->published;
    }

    /**
     * Set the value of published
     *
     * @param string $published
     * @return  self
     */
    public function setPublished(string $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser(): User
    {
        return $this->user;
    }


    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return $this
     */
    public function setArticle(Article $article): self
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


}
