<?php

declare(strict_types=1);

namespace App;

class View {
  private string $viewName;
  private array $data;


  public function render($viewName, $data=null) {
    include(__DIR__.'/../templates/'.$viewName);
  }

  public function redirect($viewName, $data=null) {
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://".$host."/".$viewName);
  }
}
