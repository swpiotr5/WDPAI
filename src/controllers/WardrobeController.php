<?php

require_once __DIR__ . '/../repository/WardrobeRepository.php';

class WardrobeController extends AppController
{
    private $message = [];
    private $wardrobeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->wardrobeRepository = new WardrobeRepository();
    }

    public function assignClothesToUser()
    {
        error_log("assignClothesToUser() called");
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
        if($contentType === "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            error_log(print_r($decoded, true));
    
            if(is_array($decoded) && isset($decoded['userId'], $decoded['clothes'])){
                $userId = $decoded['userId'];
                $clothes = is_array($decoded['clothes']) ? $decoded['clothes'] : [$decoded['clothes']];
                $this->wardrobeRepository->assignClothesToUser($userId, $clothes);
                error_log("Data received and saved to database");
            }
            else{
                error_log("No data received");
            }
    
            return $this->render('wardrobe');
        }
    
        if ($this->isPost() && isset($_POST['userId'], $_POST['clothes'])){
            $userId = $_POST['userId'];
            $clothes = is_array($_POST['clothes']) ? $_POST['clothes'] : [$_POST['clothes']];
            $this->wardrobeRepository->assignClothesToUser($userId, $clothes);
            error_log("Data received and saved to database");
    
            return $this->render('wardrobe');
        }
        error_log("No data received");
        return $this->render('wardrobe');
    }
}

