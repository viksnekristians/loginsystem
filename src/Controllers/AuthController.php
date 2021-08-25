<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Structures\UserRegisterStructure;
use App\Structures\UserLoginStructure;
use App\Models\UserModel;
use App\Session;
use App\View;

class AuthController {


  public function login(): void {
    $session = Session::getInstance();
    $view = new View();
    if ($session->get('user_id')) {
      $view->redirect('/', ['errors' => ['You are already logged in!']]);
    } else {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $view->render('/login.phtml');
      } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userStructure = new UserLoginStructure($username, $password);
        $userModel = new UserModel();
        $userModel->checkIfUsernameExists($userStructure->username);
        $userModel->checkPassword($userStructure->username, $userStructure->password);
        $id = $userModel->getId($userStructure->username, $userStructure->password);
        if ($id) {
          $session->regenerate();
          $session->set('user_id', $id);
          $view->redirect('/');
        } else {
          $view->redirect('/login', ['errors' => ['Username and/or password is incorrect!']]);
        }
        
      }
    }

}

  public function register(): void {
    $session = Session::getInstance();
    $view = new View();
    if (!$session->get('user_id')) {
      $view->render('/register.phtml');
    } else {
      $view->redirect('/', );
    }
  }

  public function store()
  {
    $session = Session::getInstance();
    $view = new View();
    if (!$session->get('user_id')) {  
      $name = $_POST['name'];
      $lastName = $_POST['lastname'];
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $userStructure = new UserRegisterStructure($name, $lastName, $email, $username, $password);

      $errors = self::validateRegistration($userStructure);

      if (!$errors) {
        $userModel = new UserModel();
        $name = $userStructure->name;
        $lastName =  $userStructure->lastName;
        $email =  $userStructure->email;
        $username = $userStructure->username;
        $password =  $userStructure->password;
  
        if ($userModel->saveUser($name, $lastName, $email, $username, $password)) {
          $view->render('register.phtml', ['success' => true]); 
        } else {
          $view->render('register.phtml', ['success' => false]);
        }

    } else {
      $view->redirect('/register', ['errors' => $errors ]);
    } 

  } else {
    $view->redirect('');
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
    $session->destroy();
    $view->redirect('');
  }

  private function validateRegistration($structure) {
    $errors = [];
    if (strlen($structure->name) < 1 || strlen($structure->lastName) < 1) {
      $errors[] = "You have to provide name and last name";
    }

    if(!filter_var($structure->email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Please enter a valid email';
    }

    if (mb_strlen($structure->password) < 8) {
      $errors[] = "Password must be at least 8 characters long";
    }

    if (strlen($structure->username) < 1 ) {
      $errors[] = "You have to provide username";
    }

    $userModel = new UserModel();

    if($userModel->checkIfUsernameExists($structure->username)) {
      $errors[] = "Username already exists";
    }

    if($userModel->checkIfEmailIsRegistered($structure->email)) {
      $errors[] = "Email is already registered";
    }


    return $errors;

  }

}
