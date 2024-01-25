<?php
session_start();
use models\Activity;
use models\Forecast;
use repository\ActivityRepository;
use repository\ForecastRepository;

require_once 'AppController.php';
require_once __DIR__ . '/../models/Activity.php';
require_once __DIR__ . '/../models/Forecast.php';
require_once __DIR__ . '/../repository/ActivityRepository.php';
require_once __DIR__ . '/../repository/ForecastRepository.php';
require_once __DIR__ . '/../../assets/activities.php';


class ActivityController extends AppController
{
    private $activityRepository;
    private $forecastRepository;

    public function __construct()
    {
        parent::__construct();
        $this->activityRepository = new ActivityRepository();
        $this->forecastRepository = new ForecastRepository();
        $this->activities = new Activities();
    }

    public function active()
    {
        $user_id = $_SESSION['id'];
        $currentWeather = $this->forecastRepository->getCurrentForecast($user_id);
    
        if ($currentWeather == null) {
            $this->render('active', ['suggestedActivities' => null, 'message' => '']);
            return;
        }
    
        $suggestedActivities = [];
        $message = '';
    
        if ($currentWeather->getRain()) {
            $array = $this->activities->getActivitiesForRainyWeather();
            shuffle($array);
            $suggestedActivities = array_slice($array, 0, 9);
            $array = $this->activities->getMessagesRainyWeather();
            shuffle($array);
            $message = array_pop($array);
        } else {
            $temperature = $currentWeather->getTemperature();
            
            if ($temperature < 0) {
                $array = $this->activities->getActivitiesBelowZero();
                shuffle($array);
                $suggestedActivities = array_slice($array, 0, 9);
                $array = $this->activities->getMessagesBelowZero();
                shuffle($array);
                $message = array_pop($array);
            } elseif ($temperature >= 0 && $temperature < 10) {
                $array = $this->activities->getActivitiesZeroToTenDegrees();
                shuffle($array);
                $suggestedActivities = array_slice($array, 0, 9);
                $array = $this->activities->getMessagesZeroToTenDegrees();
                shuffle($array);
                $message = array_pop($array);
            } elseif ($temperature >= 10 && $temperature < 20) {
                $array = $this->activities->getActivitiesTenToTwentyDegrees();
                shuffle($array);
                $suggestedActivities = array_slice($array, 0, 9);
                $array = $this->activities->getMessagesTenToTwentyDegrees();
                shuffle($array);
                $message = array_pop($array);
            } elseif ($temperature >= 20 && $temperature < 30) {
                $array = $this->activities->getActivitiesTwentyToThirtyDegrees();
                shuffle($array);
                $suggestedActivities = array_slice($array, 0, 9);
                $array = $this->activities->getMessagesTwentyToThirtyDegrees();
                shuffle($array);
                $message = array_pop($array);
            } else {
                $array = $this->activities->getActivitiesFromThirtyDegrees();
                shuffle($array);
                $suggestedActivities = array_slice($array, 0, 9);
                $array = $this->activities->getMessagesFromThirtyDegrees();
                shuffle($array);
                $message = array_pop($array);
            }
        }
        // Render suggested activities and message
        $this->render('active', ['suggestedActivities' => $suggestedActivities, 'message' => $message]);
    }
    
}