<?php

use models\User;

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $username): ?User
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user == false){
            return null;
        }

        return new User(
            $user['email'],
            $user['username'],
            $user['password'],
            $user['avatar']
        );
    }

    public function getUserByEmail(string $email): ?User{
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user == false){
            return null;
        }

        return new User(
            $user['email'],
            $user['username'],
            $user['password'],
            $user['avatar']
        );
    }

    public function getIdByEmail(string $email): ?int{
        $stmt = $this->database->connect()->prepare('SELECT user_id FROM public.users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result == false){
            return null;
        }

        return (int) $result['user_id'];
    }

    public function addUser(User $user) : void{
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, username, password, avatar) VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getAvatar()
        ]);
    }
    public function updateAvatar(int $userId, string $avatarUrl): void {
        $stmt = $this->database->connect()->prepare('
            UPDATE users SET avatar = :avatar WHERE user_id = :id
        ');
    
        $stmt->bindParam(':avatar', $avatarUrl, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
        $stmt->execute();
    }
}

