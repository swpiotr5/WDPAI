<?php

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
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType === "application/json"){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            echo $this->forecastRepository->addForecast();
        }

        if ($this->isPost()){
            // TODO create new project object and save it in database
            $forecast = new Forecast($_POST['cityName'], $_POST['weatherDescription'], $_POST['wind'], $_POST['pressure'], $_POST['temperature'], $_POST['humidity'], $_POST['sunset'], $_POST['sunrise'], $_POST['rainPossibility'], $_POST['time']);
            $this->forecastRepository->addForecast($forecast);

            return $this->render('forecast');
        }
        return $this->render('forecast');
    }

}
