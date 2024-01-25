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

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.users');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new User(
                $user['email'],
                $user['username'],
                $user['password'],
                $user['avatar'],
            );
        }
        return $userObjects;
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

    public function deleteUser(string $username): void{
        $stmt = $this->database->connect()->prepare('DELETE FROM public.users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
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

    public function addUser(User $user) : void {
        try {
            $this->beginTransaction();
    
            $stmt = $this->database->connect()->prepare('
                INSERT INTO users (email, username, password, avatar) VALUES (?, ?, ?, ?)
            ');
    
            $stmt->execute([
                $user->getEmail(),
                $user->getUsername(),
                $user->getPassword(),
                $user->getAvatar()
            ]);
    
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }
    public function updateAvatar(int $userId, string $avatarUrl): void {
        $stmt = $this->database->connect()->prepare('
            UPDATE users SET avatar = :avatar WHERE user_id = :id
        ');
    
        $stmt->bindParam(':avatar', $avatarUrl, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
        $stmt->execute();
    }
    public function beginTransaction() {
        $stmt = $this->database->connect();
        $stmt->beginTransaction();
    }
    
    public function commit() {
        $stmt = $this->database->connect();
        if ($stmt->inTransaction()) {
            $stmt->commit();
        }
    }
    
    public function rollBack() {
        $stmt = $this->database->connect();
        if ($stmt->inTransaction()) {
            $stmt->rollBack();
        }
    }
    public function addNameToDatabase(string $firstName, string $lastName, int $userId): void {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details WHERE user_id = :id
        ');
    
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $stmt = $this->database->connect()->prepare('
                UPDATE user_details SET first_name = :firstName, last_name = :lastName WHERE user_id = :id
            ');
        } else {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO user_details (user_id, first_name, last_name) VALUES (:id, :firstName, :lastName)
            ');
        }
    
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
        $stmt->execute();
    }
}

