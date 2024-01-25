<?php

namespace models;

class Activity{
    private $activity_name;

    public function __construct(string $activity_name){
        $this->activity_name = $activity_name;
    }

    public function getActivityName(){
        return $this->activity_name;
    }

    public function setActivityName($activity_name){
        $this->activity_name = $activity_name;
    }
}