<?php

namespace models;

class User
{
    private $email;
    private $name;
    private $surname;
    private $password;

    public function __construct($email, $name, $surname, $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }


}