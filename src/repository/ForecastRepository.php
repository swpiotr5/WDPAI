<?php

namespace repository;

use models\Forecast;
use PDO;
use Repository;

require_once 'Repository.php';
require_once __DIR__ . '/../models/Forecast.php';

class ForecastRepository extends Repository
{
    public function getForecasts(string $cityName): ?Forecast
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.forecasts WHERE cityName = :cityName');
        $stmt->bindParam(':cityName', $cityName, PDO::PARAM_STR);
        $stmt->execute();

        $forecast = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($forecast == false) {
            return null;
        }

        return new Forecast(
            $forecast['cityName'],
            $forecast['weatherDescription'],
            $forecast['preciseWeatherDescription'],
            $forecast['wind'],
            $forecast['pressure'],
            $forecast['temperature'],
            $forecast['humidity'],
            $forecast['sunset'],
            $forecast['sunrise'],
            $forecast['rain'],
            $forecast['time'],
            $forecast['isCurrent'],
            $forecast['user_id'],
            $forecast['weatherIconUrl']
        );
    }

    public function getCurrentForecast($user_id): ?Forecast{
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.forecasts WHERE "isCurrent" = true AND "user_id" = :user_id');
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $forecast = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($forecast == false) {
            return null;
        }
    
        return new Forecast(
            $forecast['cityName'],
            $forecast['weatherDescription'],
            $forecast['preciseWeatherDescription'],
            $forecast['wind'],
            $forecast['pressure'],
            $forecast['temperature'],
            $forecast['humidity'],
            $forecast['sunset'],
            $forecast['sunrise'],
            $forecast['rain'],
            $forecast['time'],
            $forecast['isCurrent'],
            $forecast['user_id'],
            $forecast['weatherIconUrl']
        );
    }

    public function getFutureForecasts($user_id): ?array{
        $stmt = $this->database->connect()->prepare('SELECT * FROM public.forecasts WHERE "isCurrent" = false AND "user_id" = :user_id');
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $forecasts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($forecasts == false) {
            return null;
        }

        $forecastsArray = array();
        foreach ($forecasts as $forecast) {
            array_push($forecastsArray, new Forecast(
                $forecast['cityName'],
                $forecast['weatherDescription'],
                $forecast['preciseWeatherDescription'],
                $forecast['wind'],
                $forecast['pressure'],
                $forecast['temperature'],
                $forecast['humidity'],
                $forecast['sunset'],
                $forecast['sunrise'],
                $forecast['rain'],
                $forecast['time'],
                $forecast['isCurrent'],
                $forecast['user_id'],
                $forecast['weatherIconUrl']
            ));
        }
    
        return $forecastsArray;
    }

    public function addForecast(Forecast $forecast): void
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO forecasts (
            "cityName", "weatherDescription", "preciseWeatherDescription", wind, pressure, temperature, humidity, 
            sunset, sunrise, rain, "time", "isCurrent", "user_id", "weatherIconUrl"
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        var_dump($forecast->getIsCurrent());

        $isCurrent = $forecast->getIsCurrent();
        if ($isCurrent === '') {
            $isCurrent = 'false';
        } else {
            $isCurrent = $isCurrent ? 'true' : 'false';
        }

        $stmt->execute([
            $forecast->getCityName(),
            $forecast->getWeatherDescription(),
            $forecast->getPreciseWeatherDescription(),
            $forecast->getWind(),
            $forecast->getPressure(),
            $forecast->getTemperature(),
            $forecast->getHumidity(),
            $forecast->getSunset(),
            $forecast->getSunrise(),
            $forecast->getRain(),
            $forecast->getTime(),
            // $forecast->getIsCurrent()
            $isCurrent,
            $forecast->getUser_id(),
            $forecast->getWeatherIconUrl()
        ]);
    }
    
    public function deleteForecastsByUserId($user_id)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM forecasts WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
}