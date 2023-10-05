<?php

namespace App\Models;

class User
{
    private ?int $id = null;
    private ?string $firstname = null;
    private ?string $lastname = null;
    private ?int $age = null;
    private ?string $avatar;
    private ?string $email = null;
    private string $role;
    private string $password;
    private string $createdAt;
    private string $updatedAt;
    private Comment $comments;
    private Article $articles;


    public function __construct()
    {
        $this->table = "users";
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }


    /**
     * @param string $updatedAt
     * @return $this
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
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword():string
    {
        return $this->password;
    }


    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole():string
    {
        return $this->role;
    }


    /**
     * @param string $role
     * @return $this
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar():string
    {
        return $this->avatar;
    }


    /**
     * @param string|null $avatar
     * @return $this
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge():int
    {
        return $this->age;
    }


    /**
     * @param string $age
     * @return $this
     */
    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname():string
    {
        return $this->lastname;
    }


    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname():string
    {
        return $this->firstname;
    }


    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getComments(): Comment
    {
        return $this->comments;
    }

    public function setComments(Comment $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function getArticles(): Article
    {
        return $this->articles;
    }

    public function setArticles(Article $articles): self
    {
        $this->articles = $articles;
        return $this;
    }
}
