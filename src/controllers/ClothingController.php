<?php

use repository\ClothingRepository;

require_once 'AppController.php';
require_once __DIR__ . '/../models/Clothing.php';
require_once __DIR__ . '/../repository/ClothingRepository.php';

class ClothingController extends AppController
{
    private $clothingRepository;

    public function __construct()
    {
        parent::__construct();
        $this->clothingRepository = new ClothingRepository();
    }

    public function getAllClothes()
    {
        try {
            $clothes = $this->clothingRepository->getAllClothes();
            header('Content-Type: application/json');
            echo json_encode($clothes);
            exit();
        } catch (Exception $e) {
            // Log the error for debugging purposes
            error_log('Error in getAllClothes: ' . $e->getMessage() . ' ' . $e->getTraceAsString());

            // Return a JSON response with an error message
            header('Content-Type: application/json');
            echo json_encode(['error' => 'An error occurred. Please check the logs for details.']);
            exit();
        }
    }

}