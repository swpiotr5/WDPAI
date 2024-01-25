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
    
        // Begin the transaction
        $userRepository->beginTransaction();
    
        try {
            $user = $userRepository->getUser($username);
    
            if(!$user){
                throw new Exception("User not exists!");
            }
    
            if (!password_verify($password, $user->getPassword())){
                throw new Exception("Wrong password");
            }
    
            session_start();
    
            $_SESSION["id"] = $userRepository->getIdByEmail($user->getEmail());
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["email"] = $user->getEmail();
            $_SESSION["avatar"] = $user->getAvatar();
    
            // Commit the transaction if everything succeeds
            $userRepository->commit();
    
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/forecast");
            return;
        } catch (Exception $e) {
            // Rollback the transaction if any error occurs
            $userRepository->rollBack();
            return $this->render('login', ['messages' => [$e->getMessage()]]);
        }
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
        $avatar = "public\img\user.png";

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

        $user = new User($email, $username, $password, $avatar);

        $userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You have been successfully registered!']]);
    }

    public function updateAvatar(): string
    {
        if (!isset($_SESSION["id"])) {
            return $this->render('userpage', ['messages' => ['User ID not set']]);
        }
    
        $userRepository = new UserRepository();
        $userId = $_SESSION["id"]; // Pobierz id użytkownika z żądania
    
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
        if($contentType === "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
    
            if(is_array($decoded) && isset($decoded['avatar'])){
                $avatarUrl = $decoded['avatar']; // Pobierz URL avatara z żądania
                $_SESSION["avatar"] = $avatarUrl; // Zaktualizuj URL avatara w sesji
                $userRepository->updateAvatar($userId, $avatarUrl);
                return $this->render('userpage', ['messages' => ['Avatar has been successfully updated!']]);
            }
            else{
                return $this->render('userpage', ['messages' => ['No avatar data received']]);
            }
        }
    
        if ($this->isPost() && isset($_POST['avatar'])){
            $avatarUrl = $_POST['avatar']; // Pobierz URL avatara z żądania
            $_SESSION["avatar"] = $avatarUrl; // Zaktualizuj URL avatara w sesji
            $userRepository->updateAvatar($userId, $avatarUrl);
            return $this->render('userpage', ['messages' => ['Avatar has been successfully updated!']]);
        }
    
        return $this->render('userpage', ['messages' => ['No avatar data received']]);
    }
    public function addNameToDatabase(){
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('userpage');
        }

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];

        $userRepository->addNameToDatabase($firstName, $lastName, $_SESSION["id"]);

        return $this->render('userpage', ['messages' => ['Name has been successfully added!']]);
    }
    public function userpage(): void {
        if ($_SESSION["username"] === "admin") {
            $userRepository = new UserRepository();
            $users = $userRepository->getAllUsers();
            $this->render('userpage', ['users' => $users]);
        } else {
            $this->render('userpage');
        }
    }
    public function deleteUser(){
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('userpage');
        }

        $user = $_POST["user"];

        $userRepository->deleteUser($user);

        return $this->render('userpage', ['messages' => ['User has been successfully deleted!']]);
    }
}