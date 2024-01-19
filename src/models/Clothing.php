<?php

namespace models;

class Clothing
{
    private $clothing_id;
    private $clothing_category;
    private $clothing_type;
    private $season;

    public function __construct($clothing_id, $clothing_category, $clothing_type, $season)
    {
        $this->clothing_id = $clothing_id;
        $this->clothing_category = $clothing_category;
        $this->clothing_type = $clothing_type;
        $this->season = $season;
    }
    public function getClothing_id()
    {
        return $this->clothing_id;
    }
    public function getClothing_category()
    {
        return $this->clothing_category;
    }
    public function getClothing_type()
    {
        return $this->clothing_type;
    }
    public function getSeason()
    {
        return $this->season;
    }
    public function toArray()
    {
        return [
            'clothing_id' => $this->getClothing_id(),
            'clothing_category' => $this->getClothing_category(),
            'clothing_type' => $this->getClothing_type(),
            'season' => $this->getSeason(),
        ];
    }
}