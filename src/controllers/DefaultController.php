<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        $this->render('login');
    }

    public function forecast(){
        $this->render('forecast');
    }

    public function location(){
        $this->render('location');
    }

    public function active(){
        $this->render('active');
    }

    public function wardrobe(){
        $this->render('wardrobe');
    }

    public function userpage(){
        $this->render('userpage');
    }
}