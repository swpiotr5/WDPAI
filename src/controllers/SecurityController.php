<?php

use models\User;

require_once "AppController.php";
require_once __DIR__ .'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login(){

        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($username);

        if(!$user){
            return $this->render('login', ['messages' => ['User not exists!']]);
        }

        if ($user->getUsername() != $username){
            return $this->render('login', ['messages'=>['User with this username not exists']]);
        }

        if ($user->getPassword() != $password){
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/forecast");
    }
}