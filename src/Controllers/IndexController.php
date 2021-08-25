<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Structures\UserRegisterStructure;
use App\Structures\UserLoginStructure;
use App\View;
use App\Session;

class IndexController {
  public function index() {
    $view = new View;
    $view->render('index.php');
  }

}
