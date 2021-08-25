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

  public function buildTreeView($arr,$parent,$level = 0,$prelevel = -1){
    $tree = '';
    foreach($arr as $id=>$data){
        if($parent==$data['parent_id']){
            if($level>$prelevel){
                $tree .= "<ol>";
            }
            if($level==$prelevel){
              $tree .= "</li>";
            }
            $tree .= "<li>".$data['section_title'];
            if($level>$prelevel){
                $prelevel=$level;
            }
            $level++;
            $this->buildTreeView($arr,$id,$level,$prelevel);
            $level--;	
        }
    }
    if($level==$prelevel){
      $tree .= "</li></ol>";
    }

    return $tree;
}
}
