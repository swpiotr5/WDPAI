<?php

namespace repository;
use PDO;
use Repository;
use models\Wardrobe;

require_once 'Repository.php';
require_once __DIR__.'/../models/Wardrobe.php';

class WardrobeRepository extends Repository {

    public function getWardrobeByUserId(int $user_id): ?array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('SELECT * FROM public.wardrobe WHERE user_id = :user_id');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $wardrobe = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($wardrobe == false){
            return null;
        }

        foreach($wardrobe as $item){
            $result[] = new Wardrobe(
                $item['user_id'],
                $item['clothing_id']
            );
        }

        return $result;
    }
    public function assignClothesToUser(int $userId, array $clothesIds): void
    {
        // Create a PDO instance
        $db = $this->database->connect();

        // Prepare a statement to delete all clothes for the user
        $deleteStmt = $db->prepare('DELETE FROM wardrobe WHERE user_id = ?');
        $deleteStmt->execute([$userId]);

        // Prepare a statement to insert new clothes for the user
        $insertStmt = $db->prepare('
            INSERT INTO wardrobe (
                user_id, clothing_id
            ) VALUES (?, ?)
        ');

        foreach ($clothesIds as $clothingId) {
            $insertStmt->execute([
                $userId,
                $clothingId
            ]);
        }
    }
    public function getClothesByUserId($user_id) {
        $stmt = $this->database->connect()->prepare('
            SELECT clothing_id FROM wardrobe WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
