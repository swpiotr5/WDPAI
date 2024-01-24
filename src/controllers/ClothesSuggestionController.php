<?php

use repository\ForecastRepository;
require_once 'AppController.php';
require_once __DIR__ . '/../repository/ForecastRepository.php';

class ClothesSuggestionController extends AppController {

    private $forecastRepository;
    private $wardrobeRepository;

    public function __construct()
    {
        parent::__construct();
        // $this->forecastRepository = new ForecastRepository();
        $this->wardrobeRepository = new WardrobeRepository();
    }

    private function calculateWindChill($temperature, $windSpeed) {
        $windChill = 13.12 + 0.6215 * $temperature - 11.37 * pow($windSpeed, 0.16) + 0.3965 * $temperature * pow($windSpeed, 0.16);
        return $windChill;
    }

    private function suggestClothing($temperature, $humidity, $rain, $windSpeed) {
        $suggestedClothingSets = [];

        if ($temperature < 0) {
            $bottomClothing = ($rain) ? "trousers" : "sweatpants";
            $upperClothing = ($rain) ? "woolen-coat" : "down-jacket";
            $additionalClothing = ($rain) ? "raincoat" : "turtleneck";
            $baseLayer = "sweater";
        
            $clothing = [$additionalClothing, $baseLayer, $upperClothing, $bottomClothing];
            $message = ($rain) ? "Cold and rainy! Consider wearing a waterproof jacket." : "Cold! A $baseLayer and $additionalClothing will be suitable.";
        } elseif ($temperature >= 0 && $temperature < 10) {
            $bottomClothing = ($rain) ? "trousers" : "sweatpants";
            $upperClothing = ($rain) ? "woolen-coat" : "denim-jacket";
            $additionalClothing = ($rain) ? "raincoat" : "tshirt";
            $baseLayer = "sweater";
        
            $clothing = [$additionalClothing, $baseLayer, $upperClothing, $bottomClothing];
            $message = ($rain) ? "Cool and rainy! Consider wearing a waterproof jacket." : "Cool! Add a $additionalClothing and $baseLayer.";
        } elseif ($temperature >= 10 && $temperature < 20) {
            $bottomClothing = ($rain) ? "trousers" : "shorts";
            $upperClothing = ($rain) ? "raincoat" : "denim-jacket";
            $additionalClothing = ($rain) ? "raincoat" : "tshirt";
            $baseLayer = "sweater";
        
            $clothing = [$additionalClothing, $baseLayer, $upperClothing, $bottomClothing];
            $message = ($rain) ? "Warm, but rainy! Consider wearing a waterproof jacket." : "Warm! Add a $additionalClothing and $baseLayer.";
        } elseif ($temperature >= 20) {
            $bottomClothing = "shorts";
            $upperClothing = ($rain) ? "raincoat" : "tshirt";
            $additionalClothing = "sweatshirt";
            $baseLayer = "shirt";
        
            $clothing = [$additionalClothing, $baseLayer, $upperClothing, $bottomClothing];
            $message = "Hot! Wear a $upperClothing and $bottomClothing, and don't forget your $additionalClothing.";
        }
        
        $suggestedClothingSets[] = [
            "clothing" => $clothing,
            "message" => $message
        ];
        
    
        return $suggestedClothingSets;
    }
    
    
    public function forecast() {
            $user_id = $_SESSION['id'];
            $current_forecast = $this->forecastRepository->getCurrentForecast($user_id);

            if ($current_forecast === null) {
                $this->render('error', ['message' => 'No current forecast available']);
                return;
            }
    
            $clothingMap = [
                1 => "raincoat",
                7 => "turtleneck",
                8 => "sweatshirt",
                9 => "sweater",
                10 => "tshirt",
                11 => "longsleeve",
                12 => "shirt",
                13 => "trousers",
                14 => "sweatpants",
                15 => "shorts",
                2 => "trench-coat",
                3 => "woolen-coat",
                4 => "denim-jacket",
                5 => "down-jacket",
                6 => "bomber-jacket"
            ];
        
            $user_clothes_ids = $this->wardrobeRepository->getClothesByUserId($user_id);
            $user_clothes = array_map(function($array) use ($clothingMap) {
                return $clothingMap[$array['clothing_id']];
            }, $user_clothes_ids);
            $temperature = $current_forecast->getTemperature();
            $humidity = $current_forecast->getHumidity();
            $rain = $current_forecast->getRain();
            $windSpeed = $current_forecast->getWind();
            $temperature = $this->calculateWindChill($temperature, $windSpeed);
            $suggestedClothing = $this->suggestClothing($temperature, $humidity, $rain, $windSpeed);
            var_dump($suggestedClothing);
    
            foreach ($suggestedClothing as $key => $clothingSet) {
                foreach ($clothingSet['clothing'] as $clothing) {
                    if (!in_array($clothing, $user_clothes)) {
                        $suggestedClothing[$key] = $this->getAlternativeClothing($clothing, $user_clothes);
                    }
                }
            }
    
            $this->render('forecast', ['suggestedClothing' => $suggestedClothing]);
    }
    
    private function getAlternativeClothing($clothing, $user_clothes) {
        $alternativeClothing = [
            "raincoat" => ["trench-coat", "woolen-coat"],
            "turtleneck" => ["longsleeve", "shirt"],
            "sweatshirt" => ["sweater", "tshirt"],
            "sweater" => ["tshirt", "longsleeve"],
            "tshirt" => ["longsleeve", "shirt"],
            "longsleeve" => ["shirt", "tshirt"],
            "shirt" => ["tshirt", "longsleeve"],
            "trousers" => ["sweatpants", "shorts"],
            "sweatpants" => ["shorts", "trousers"],
            "shorts" => ["trousers", "sweatpants"],
            "trench-coat" => ["woolen-coat", "down-jacket"],
            "woolen-coat" => ["down-jacket", "bomber-jacket"],
            "denim-jacket" => ["bomber-jacket", "woolen-coat"],
            "down-jacket" => ["woolen-coat", "denim-jacket"],
            "bomber-jacket" => ["denim-jacket", "woolen-coat"]
        ];
    
        if (isset($alternativeClothing[$clothing])) {
            foreach ($alternativeClothing[$clothing] as $alternative) {
                if (in_array($alternative, $user_clothes)) {
                    return $alternative;
                }
            }
        }
    
        return "tshirt";
    }
}