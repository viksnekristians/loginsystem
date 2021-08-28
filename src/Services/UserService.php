<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\UserModel;
use App\View;
use App\Session;

class UserService {


  public function signUp($userRegisterStructure) {
    $view = new View();
    if ($this->validateUserRegisterStructure($userRegisterStructure)) {
      $userModel = new UserModel();
      $name = $userRegisterStructure->name;
      $lastName =  $userRegisterStructure->lastName;
      $email =  $userRegisterStructure->email;
      $username = $userRegisterStructure->username;
      $password =  $userRegisterStructure->password;

      if ($userModel->saveUser($name, $lastName, $email, $username, $password)) {
        $view->render('register.phtml', ['success' => true]);
    } else {
      $view->render('register.phtml', ['success' => false]);
    }
    

  } else {
    $view->render('register.phtml', ['success' => false, 'errors' => $errors]);
  }
}

  public function signIn($userLoginStructure) {
    $userModel = new UserModel();
    $session = new Session();
    $userModel->checkIfUsernameExists($userLoginStructure->username);
    $userModel->checkPassword($userLoginStructure->username, $userLoginStructure->password);
    $id = $userModel->getId($userLoginStructure->username, $userLoginStructure->password);
    $session->regenerate();
    $session->set('user_id', (int)$id);

    $view = new View();
    $view->redirect('', ['success' => true]);
  }

  public function logout() {
    $session = new Session();
    $session->destroy();
    $view = new View();
    $view->redirect('');
  }

  private function validateUserRegisterStructure($structure) {
    $errors = [];
    if (strlen($structure->name) < 1 || strlen($structure->lastName) < 1) {
      $errors[] = "You have to provide name and last name";
    }

    if(!filter_var($structure->email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Please enter a valid email';
    }

    if (mb_strlen($structure->password) < 6) {
      $errors[] = "Ciepa 7";
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
