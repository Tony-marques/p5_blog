<?php

namespace App\Models;

class Article
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $content = null;
    private ?string $chapo = null;
    private ?string $author = null;
    private string|\DateTimeImmutable $createdAt;
    private string|\DateTimeImmutable $updatedAt;
    private ?int $userId = null;
    private $user;
    private Comment|array $comment;

    /**
     * Get the value of content
     */
    public function getContent():string
    {
        return $this->content;
    }


    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle():string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     * @return  self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdatedAt():string
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updated_at
     *
     * @param string $updatedAt
     * @return  self
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt():string
    {
        return $this->createdAt;
    }

    /**
     * Set the value of created_at
     *
     * @param string $createdAt
     * @return  self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of author
     */
    public function getAuthor():string
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @param string $author
     * @return  self
     */
    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId():?int
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
     * @return mixed
     */
    public function getUser():User
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

    public function getId():?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getComment(): Comment|array
    {
        return $this->comment;
    }

    public function setComment(Comment|array $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    public function setChapo(?string $chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }
}
