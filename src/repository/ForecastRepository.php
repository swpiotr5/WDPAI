<?php

namespace repository;

use models\Forecast;
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
            $forecast['wind'],
            $forecast['pressure'],
            $forecast['temperature'],
            $forecast['humidity'],
            $forecast['sunset'],
            $forecast['sunrise'],
            $forecast['rainPossibility'],
            $forecast['time']
        );
    }

    public function addForecast(Forecast $forecast): void
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO forecasts (cityName, weatherDescription, wind, pressure, temperature, humidity, sunset, sunrise, rainPossibility, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $stmt->execute([
            $forecast->getCityName(),
            $forecast->getWeatherDescription(),
            $forecast->getWind(),
            $forecast->getPressure(),
            $forecast->getHumidity(),
            $forecast->getSunset(),
            $forecast->getSunrise(),
            $forecast->getRainPossibility(),
            $forecast->getTime()

        ]);
    }
}