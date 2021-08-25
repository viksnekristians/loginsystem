<?php

declare(strict_types=1);

namespace App\Models;

use App\db\Database;


class UserModel extends Database {


  public function saveUser($name, $lastName, $email, $username, $password) {
      $sql = "insert into users(name, lastname, email, username, password)
      values (?,?,?,?,?);";
      //"Prepared statement" izveide, izpilde
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute([$name,$lastName, $email,$username,$password])) return true; else return false;
  }

  public function checkIfUsernameExists($username) {
    $sql = "select from users where username = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username]);
    $results = $stmt->fetchAll();
    if ($results) {
      return true;
    } else return false;
  }

  public function checkIfEmailIsRegistered($email) {
    $sql = "select from users where email = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email]);
    $results = $stmt->fetchAll();
    if ($results) {
      return true;
    } else return false;
  }

  public function checkPassword($username, $password) {
    $sql = "select password from users where username = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username]);
    $results = $stmt->fetchAll();
    if (!$results) return false;
    if ($results[0]['password'] === $password) {
      return true;
    } else return false;
  }

  public function getId($username, $password) {
    $sql = "select id from users where username = ? and password = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username, $password]);
    $results = $stmt->fetchAll();
    if (empty($results)) return 0;
    else return (int)$results[0]['id'];
    
  }

}
