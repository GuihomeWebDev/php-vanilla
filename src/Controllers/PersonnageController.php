<?php

namespace App\Controllers;

class PersonnageController extends AbstractController
{
    public function home()
    {
      
       return $this->render('home');
    }

    public function list($id)
    {
        return $this->render('list');
    }
}