<?php

declare(strict_types=1);

namespace App\db;
use PDO;

class Database {

//jānomaina, lai parametrus var passot iekšā
  protected function connect() {
    $host="localhost:3306";
    $user="root";
    $password="";
    $dbName="homework";

    $dsn = 'mysql:host='.$host. ';dbname='. $dbName;
    $pdo = new PDO($dsn, $user , $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}
