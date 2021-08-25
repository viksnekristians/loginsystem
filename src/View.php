<?php

declare(strict_types=1);

namespace App;
use App\Session;

class View {
  private string $viewName;
  private array $data;
  

  public function render($viewName, $data=null) {
    include(__DIR__.'/../resources/views/'.$viewName);
  }

  public function redirect($viewName, $data=null) {
    $session = Session::getInstance();
    $session->set('errors', $data['errors']);
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://".$host.$viewName);
  }
}
