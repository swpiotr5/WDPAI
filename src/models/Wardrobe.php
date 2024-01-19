<?php

namespace models;

class Wardrobe{
    private $user_id;
    private $clothing_id;

    public function __construct(int $user_id, int $clothing_id)
    {
        $this->user_id = $user_id;
        $this->clothing_id = $clothing_id;
    }
    public function getUser_id()
    {
        return $this->user_id;
    }
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getClothing_id()
    {
        return $this->clothing_id;
    }
    public function setClothing_id($clothing_id)
    {
        $this->clothing_id = $clothing_id;
    }
}