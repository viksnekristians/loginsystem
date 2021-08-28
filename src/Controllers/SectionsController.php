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
        $view = new View();
        $id = $_POST['edit'];
        $model = new SectionModel();
        $section = $model->getSection($id);
        $title = $section['section_title'];
        $description = $section['section_description'];
        $view->render('edit.php', [$id, $title,$description]);
        
    }

    public function update()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $model = new SectionModel();
        $view = new View();
        if ($id && $title && $desc) {
            if ($model->editSection($id, $title, $desc)) {
                $view->redirect('/sections');
            } else {
                $view->redirect('/sections', ['errors' => ['Something went wrong!']] );
            }
        } else {
            $view->redirect('/sections', ['errors' => ['You have to provide title and description!']] );
        }
    }

    public function add()
    {
        $view = new View();
        $parentId = $_POST['add'];
        $model = new SectionModel();
        $view->render('add.php', $parentId);
        
    }

    public function store()
    {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $parentId = $_POST['parentId'];
        $model = new SectionModel();
        $view = new View();
        if ($title && $desc ) {
            if ($model->addSection($parentId, $title, $desc)) {
                $view->redirect('/sections');
            } else {
                $view->redirect('/sections', ['errors' => ['Something went wrong!']] );
            }
        } else {
            $view->redirect('/sections', ['errors' => ['You have to provide title and description!']] );
        }
    }

    public function delete()
    {
        $id = $_POST['delete'];
        $model = new SectionModel();
        $view = new View();
        if ($model->deleteSection($id)) {
            $view->redirect('/sections');
        }
    }
}
