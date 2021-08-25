<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Session;
use App\Models\SectionModel;

class SectionsController
{
    public function display()
    {
    $session = Session::getInstance();
    $view = new View();
    if ($session->get('user_id')) {
        $model = new SectionModel();
        $sections = $model->getSections();
        $view = new View();
        $view->render('sections.php', $sections);
    } else {
      $view->redirect('/', ['errors' => ['You have to be logged in to access secure section!']]);
        }   
    }

    public function edit()
    {
        echo $_POST['edit'];
    }

    public function delete()
    {
        echo $_POST['edit'];
    }
}
