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

        if (!password_verify($password, $user->getPassword())){
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        session_start();

        $_SESSION["username"] = $user->getUsername();
        $_SESSION["email"] = $user->getEmail();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/forecast");
        return;
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
        exit;
    }
    
    public function register(){
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $username = $_POST["username-register"];
        $password = $_POST["password-register"];
        $password_confirm = $_POST["password-confirm"];
        $email = $_POST["email-register"];

        if ($password != $password_confirm){
            return $this->render('login', ['messages' => ['Passwords are not the same!']]);
        } else{
            $password = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($userRepository->getUser($username)){
            return $this->render('login', ['messages' => ['User with this username already exists!']]);
        }

        if ($userRepository->getUserByEmail($email)){
            return $this->render('login', ['messages' => ['User with this email already exists!']]);
        }

        $user = new User($email, $username, $password);

        $userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You have been successfully registered!']]);
    }
}