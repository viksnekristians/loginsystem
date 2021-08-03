<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Structures\UserRegisterStructure;
use App\Structures\UserLoginStructure;
use App\Services\UserService;
use App\View;
use App\Session;

class IndexController {
  public function index() {
    $view = new View;
    $view->render('index.phtml', []);
  }

  public function dashboard() {
    $session = Session::getInstance();
    $view = new View();
    if ($session->get('user_id')) {
      $view->render('dashboard.phtml', []);
    } else {
      $view->redirect('');
    }
  }
}
