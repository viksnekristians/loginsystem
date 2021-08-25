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
    if (is_array($data)) {
      if (array_key_exists('errors', $data)){
        $session->set('errors', $data['errors']);
      }
    }
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://".$host.$viewName);
  }

  public function buildTreeView($arr,$parent,$level = 0,$prelevel = -1){
    $tree = '';
    foreach($arr as $id=>$data){
        if($parent==$data['parent_id']){
            if($level>$prelevel){
                echo "<ol>";
            }
            if($level==$prelevel){
                echo "</li>";
            }
            echo "<li>".$data['section_title'];
            if($level>$prelevel){
                $prelevel=$level;
            }
            $level++;
            $this->buildTreeView($arr,$id,$level,$prelevel);
            $level--;	
        }
    }
    if($level==$prelevel){
        echo "</li></ol>";
    }
}
}
