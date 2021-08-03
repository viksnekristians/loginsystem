<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Structures\UserRegisterStructure;
use App\Structures\UserLoginStructure;
use App\Services\UserService;
use App\Session;
use App\View;

class AuthController {


  public function login(): void {
    $session = Session::getInstance();
    $view = new View();
    if ($session->get('user_id')) {
      $view->redirect('', ['errors' => ['You are already logged in']]);
    } else {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        require_once __DIR__ . '/../../templates/login.phtml';
      } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userStructure = new UserLoginStructure($username, $password);
        $userService = new UserService();
        $userService->signIn($userStructure);
      }
    }

}

  public function register(): void {
    $session = Session::getInstance();
    $view = new View();
    if (!$session->get('user_id')) {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        require_once __DIR__ . '/../../templates/register.phtml';
      }  else {
        $name = $_POST['name'];
        $lastName = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userStructure = new UserRegisterStructure($name, $lastName, $email, $username, $password);
        $userService = new UserService();
        $userService->signUp($userStructure);
      }
    } else {
      $view->redirect('', []);
    }

  }

  public function logout() {
    $view = new View();
    $session = new Session();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $view->redirect('');
      return;
    }
    if (!$session->get('user_id')) {
      $view->redirect('');
      return;
    }
    $userService = new UserService();
    $userService->logout();
  }

  public function news() {
    $view = new View();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $view->render('news.phtml');
      return;
    }
  }

}
