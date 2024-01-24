<?php
session_start();
use models\Forecast;
use models\Wardrobe;
use repository\ForecastRepository;
use repository\WardrobeRepository;

require_once 'AppController.php';
require_once __DIR__ . '/../models/Forecast.php';
require_once __DIR__ . '/../models/Wardrobe.php';
require_once __DIR__ . '/../repository/ForecastRepository.php';
require_once __DIR__ . '/../repository/WardrobeRepository.php';

class WeatherController extends AppController
{
    private $message = [];
    private $forecastRepository;
    private $wardrobeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->forecastRepository = new ForecastRepository();
        $this->wardrobeRepository = new WardrobeRepository();
    }

    public function addForecast()
    {
        error_log("addForecast() called");
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        $user_id = $_SESSION['id'];
        if($contentType === "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            error_log(print_r($decoded, true));
            if(is_array($decoded)){
                $forecast = new Forecast(
                    $decoded['cityName'], 
                    $decoded['weatherDescription'], 
                    $decoded['preciseWeatherDescription'],
                    $decoded['wind'], 
                    $decoded['pressure'], 
                    $decoded['temperature'], 
                    $decoded['humidity'], 
                    $decoded['sunset'], 
                    $decoded['sunrise'], 
                    $decoded['rain'], 
                    $decoded['time'],
                    $decoded['isCurrent'],
                    $user_id,
                    $decoded['weatherIconUrl']
                );
                $this->forecastRepository->addForecast($forecast);
                error_log("Data received and saved to database");
            }
            else{
                error_log("No data received");
            }
    
            return $this->render('forecast');
        }

        if ($this->isPost()){
            $forecast = new Forecast(
                $_POST['cityName'], 
                $_POST['weatherDescription'], 
                $_POST['preciseWeatherDescription'],
                $_POST['wind'], 
                $_POST['pressure'], 
                $_POST['temperature'], 
                $_POST['humidity'], 
                $_POST['sunset'], 
                $_POST['sunrise'], 
                $_POST['rain'], 
                $_POST['time'],
                $_POST['isCurrent'],
                $user_id,
                $_POST['weatherIconUrl']
            );
            $this->forecastRepository->addForecast($forecast);
            error_log("Data received and saved to database");
    
            return $this->render('forecast');
        }
        error_log("No data received");
        return $this->render('forecast');
    }

    public function deleteForecasts()
    {
        error_log("deleteForecasts() called");
        $user_id = $_SESSION['id'];
    
        // Delete existing forecasts for the user
        $this->forecastRepository->deleteForecastsByUserId($user_id);
        error_log("Forecasts for user_id " . $user_id . " deleted from database");
    }

    public function forecast() {
        $user_id = $_SESSION['id'];
        $current_forecast = $this->forecastRepository->getCurrentForecast($user_id);
    
        if ($current_forecast === null) {
            $this->render('error', ['message' => 'No current forecast available']);
            return;
        }
    
        // Get the current time from the current forecast
        $current_time = strtotime($current_forecast->getTime());
    
        // Sort the future forecasts based on the time
        $future_forecasts = $this->forecastRepository->getFutureForecasts($user_id);
        usort($future_forecasts, function($a, $b) use ($current_time) {
            $time_a = strtotime($a->getTime());
            $time_b = strtotime($b->getTime());
    
            // Calculate the difference between the forecast time and the current time
            $diff_a = ($time_a >= $current_time) ? $time_a - $current_time : 24*60*60 + $time_a - $current_time;
            $diff_b = ($time_b >= $current_time) ? $time_b - $current_time : 24*60*60 + $time_b - $current_time;
    
            // Compare the differences
            return $diff_a - $diff_b;
        });
    
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

        $alternativeClothingMap = [
            "raincoat" => ["trench-coat", "woolen-coat", "denim-jacket", "down-jacket", "bomber-jacket"],
            "turtleneck" => ["sweatshirt", "sweater", "longsleeve", "shirt"],
            "sweatshirt" => ["turtleneck", "sweater", "longsleeve", "shirt"],
            "sweater" => ["turtleneck", "sweatshirt", "longsleeve", "shirt"],
            "tshirt" => ["longsleeve", "shirt"],
            "longsleeve" => ["tshirt", "shirt"],
            "shirt" => ["tshirt", "longsleeve"],
            "trousers" => ["sweatpants", "shorts"],
            "sweatpants" => ["trousers", "shorts"],
            "shorts" => ["trousers", "sweatpants"],
            "trench-coat" => ["woolen-coat", "denim-jacket", "down-jacket", "bomber-jacket"],
            "woolen-coat" => ["trench-coat", "denim-jacket", "down-jacket", "bomber-jacket"],
            "denim-jacket" => ["trench-coat", "woolen-coat", "down-jacket", "bomber-jacket"],
            "down-jacket" => ["trench-coat", "woolen-coat", "denim-jacket", "bomber-jacket"],
            "bomber-jacket" => ["trench-coat", "woolen-coat", "denim-jacket", "down-jacket"]
        ];
    
        foreach ($suggestedClothing as $key => $clothingSet) {
            foreach ($clothingSet['clothing'] as $clothingKey => $clothing) {
                if (!in_array($clothing, $user_clothes)) {
                    $alternativeFound = false;
                    if (array_key_exists($clothing, $alternativeClothingMap)) {
                        foreach ($alternativeClothingMap[$clothing] as $alternative) {
                            if (in_array($alternative, $user_clothes)) {
                                $suggestedClothing[$key]['clothing'][$clothingKey] = $alternative;
                                $alternativeFound = true;
                                break;
                            }
                        }
                    }
                    if (!$alternativeFound) {
                        $suggestedClothing[$key]['clothing'][$clothingKey] = 'unknown';
                    }
                }
            }
        }
    
        $this->render('forecast', [
            'current_forecast' => $current_forecast,
            'future_forecasts' => $future_forecasts,
            'suggestedClothing' => $suggestedClothing
        ]);
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

    public function getUserClothes() {
        $user_id = $_SESSION['id'];
        $user_clothes = $this->wardrobeRepository->getClothesByUserId($user_id);


        // $user_clothes is an array of arrays with 'clothing_id' keys
        // If you want to get a simple array of clothing ids, you can do this:
        $user_clothes_ids = array_map(function($item) {
            return $item['clothing_id'];
        }, $user_clothes);

        return $user_clothes_ids;
    }
}


