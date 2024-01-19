<?php

namespace repository;

use models\Clothing;
use PDO;
use Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Clothing.php';

class ClothingRepository extends Repository {
    public function getAllClothes(): array
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.clothing');
        $stmt->execute();

        $clothes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$clothes) {
            return [];
        }

        $clothingObjects = [];
        foreach ($clothes as $clothing) {
            if (isset($clothing['clothing_category'], $clothing['clothing_type'], $clothing['season'])) {
                $clothingObject = new Clothing(
                    $clothing['clothing_id'],
                    $clothing['clothing_category'],
                    $clothing['clothing_type'],
                    $clothing['season']
                );
                $clothingObjects[] = $clothingObject->toArray();
            }
        }

        return $clothingObjects;
    }
}