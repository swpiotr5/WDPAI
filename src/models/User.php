<?php

namespace models;

class User
{
    private $email;
    private $username;
    private $password;
    private $avatar;

    public function __construct(string $email, string $username, string $password, string $avatar)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->avatar = $avatar;
    }
        public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getAvatar(){
        return $this->avatar;
    }
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }
}