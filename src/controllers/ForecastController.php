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
                    $user_id
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
                $user_id
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
        // Przekazanie obiektu prognozy do widoku
        $this->render('forecast', ['current_forecast' => $current_forecast, 'future_forecasts' => $future_forecasts]);
    }
}


