<?php
session_start();
use models\Forecast;
use repository\ForecastRepository;

require_once 'AppController.php';
require_once __DIR__ . '/../models/Forecast.php';
require_once __DIR__ . '/../repository/ForecastRepository.php';

class ForecastController extends AppController
{

    private $message = [];
    private $forecastRepository;

    public function __construct()
    {
        parent::__construct();
        $this->forecastRepository = new ForecastRepository();
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
        $future_forecasts = $this->forecastRepository->getFutureForecasts($user_id);
    
        if ($current_forecast == null) {
            $this->render('forecast', ['current_forecast' => null, 'future_forecasts' => null]);
            return;
        }

        // Get the current time from the current forecast
        $current_time = strtotime($current_forecast->getTime());
    
        // Sort the future forecasts based on the time
        usort($future_forecasts, function($a, $b) use ($current_time) {
            $time_a = strtotime($a->getTime());
            $time_b = strtotime($b->getTime());
    
            // Calculate the difference between the forecast time and the current time
            $diff_a = ($time_a >= $current_time) ? $time_a - $current_time : 24*60*60 + $time_a - $current_time;
            $diff_b = ($time_b >= $current_time) ? $time_b - $current_time : 24*60*60 + $time_b - $current_time;
    
            // Compare the differences
            return $diff_a - $diff_b;
        });
    
        // Przekazanie obiektu prognozy do widoku
        $this->render('forecast', ['current_forecast' => $current_forecast, 'future_forecasts' => $future_forecasts]);
    }

    
}


