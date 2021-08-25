<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
use App\Session;
$session = Session::getInstance();
?>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="logo" width=60 height=50></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
              <a class="nav-link active" href="/sections">Sections</a>
        </li>
      </ul>
      <span class="navbar-text">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
          if (!$session->get('user_id')) {
            echo '<li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/register">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/login">Log In</a>
            </li>';
          } else {
            echo '<li class="nav-item">
            <form method="post" action="/logout"><button type="submit" class="btn btn-danger">Log Out</button></form>
          </li>';
          }
        ?>
      </ul>
      </span>
    </div>
  </div>
</nav>

<?php 
    foreach ($session->get('errors') as $error ) {
        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    }
    $session->unset('errors');
?>

<?php

use App\Router;
use App\Controllers\IndexController;
use App\Controllers\AuthController;
use App\Controllers\SectionsController;
use App\Models\UserModel;

$router = new Router();

$router->get('/', IndexController::class.'::index');
$router->get('/login', AuthController::class.'::login');
$router->post('/login', AuthController::class.'::login');
$router->get('/register', AuthController::class.'::register');
$router->post('/register', AuthController::class.'::store');
$router->post('/logout', AuthController::class.'::logout');
$router->get('/logout', AuthController::class.'::logout');
$router->get('/secure', IndexController::class.'::secure');
$router->get('/sections', SectionsController::class.'::display');
$router->post('/edit', SectionsController::class.'::edit');
$router->post('/update', SectionsController::class.'::update');
$router->post('/delete', SectionsController::class.'::delete');
$router->post('/add', SectionsController::class.'::add');
$router->post('/store', SectionsController::class.'::store');

$router->addNotFoundHandler(function() {
  echo "Not Found";
});

$router->run();
