<?php

declare(strict_types=1);

namespace App\Structures;

class UserRegisterStructure {
  public ?string $name = null;
  public ?string $lastName =null;
  public ?string $email = null;
  public ?string $username = null;
  public ?string $password = null;

  function __construct($name,$lastName,$email,$username,$password) {
    $this->name = $name;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->username = $username;
    $this->password = $password;
  }

}
