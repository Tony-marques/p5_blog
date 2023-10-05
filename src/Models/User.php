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
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt): self
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
     * @return  self
     */
    public function setCreatedAt($createdAt): self
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
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password): self
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
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role): self
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
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email): self
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
     * Set the value of avatar
     *
     * @return  self
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
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age): self
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
     * Set the value of lastname
     *
     * @return  self
     */
    public function setLastname($lastname): self
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
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname): self
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

    public function setComments($comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function getArticles(): Article
    {
        return $this->articles;
    }

    public function setArticles($articles): self
    {
        $this->articles = $articles;
        return $this;
    }
}
