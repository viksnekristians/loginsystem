<?php

declare(strict_types=1);

namespace App\Structures;

class UserLoginStructure {

  public ?string $username = null;
  public ?string $password = null;

  function __construct($username,$password) {

    $this->username = $username;
    $this->password = $password;
  }

}
