<?php

namespace App\models;

class UserModel extends AbstractModel
{

  public string $firstname;
  public string $lastname;
  public int $age;
  public string $avatar;
  public string $email;
  public array $role;
  public string $password;
  public \DateTime $created_at;
  public \DateTime $updated_at;

  public function __construct()
  {
    $this->table = "users";
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
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of role
   */
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @return  self
   */
  public function setRole($role)
  {
    $this->role = $role;

    return $this;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of avatar
   */
  public function getAvatar()
  {
    return $this->avatar;
  }

  /**
   * Set the value of avatar
   *
   * @return  self
   */
  public function setAvatar($avatar)
  {
    $this->avatar = $avatar;

    return $this;
  }

  /**
   * Get the value of age
   */
  public function getAge()
  {
    return $this->age;
  }

  /**
   * Set the value of age
   *
   * @return  self
   */
  public function setAge($age)
  {
    $this->age = $age;

    return $this;
  }

  /**
   * Get the value of lastname
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @return  self
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get the value of firstname
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @return  self
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }
}
