<?php

namespace models;

class Forecast
{
    private $cityName;
    private $weatherDescription;
    private $wind;
    private $pressure;
    private $temperature;
    private $humidity;
    private $sunset;
    private $sunrise;
    private $rainPossibility;
    private $time;

    public function __construct($cityName, $weatherDescription, $wind, $pressure, $temperature, $humidity, $sunset, $sunrise, $rain, $time, $isCurrent)
    {
        $this->cityName = $cityName;
        $this->weatherDescription = $weatherDescription;
        $this->wind = $wind;
        $this->pressure = $pressure;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->sunset = $sunset;
        $this->sunrise = $sunrise;
        $this->rain = $rain;
        $this->time = $time;
        $this->isCurrent = $isCurrent;
    }
    public function getCityName()
    {
        return $this->cityName;
    }
    public function setCityName($cityName): void
    {
        $this->cityName = $cityName;
    }
    public function getWeatherDescription()
    {
        return $this->weatherDescription;
    }
    public function setWeatherDescription($weatherDescription): void
    {
        $this->weatherDescription = $weatherDescription;
    }
    public function getWind()
    {
        return $this->wind;
    }
    public function setWind($wind): void
    {
        $this->wind = $wind;
    }
    public function getPressure()
    {
        return $this->pressure;
    }
    public function setPressure($pressure): void
    {
        $this->pressure = $pressure;
    }
    public function getTemperature()
    {
        return $this->temperature;
    }
    public function setTemperature($temperature): void
    {
        $this->temperature = $temperature;
    }
    public function getHumidity()
    {
        return $this->humidity;
    }
    public function setHumidity($humidity): void
    {
        $this->humidity = $humidity;
    }
    public function getSunset()
    {
        return $this->sunset;
    }
    public function setSunset($sunset): void
    {
        $this->sunset = $sunset;
    }
    public function getSunrise()
    {
        return $this->sunrise;
    }
    public function setSunrise($sunrise): void
    {
        $this->sunrise = $sunrise;
    }
    public function getRain()
    {
        return $this->rain;
    }
    public function setRain($rain): void
    {
        $this->rain = $rain;
    }
    public function getTime()
    {
        return $this->time;
    }
    public function setTime($time): void
    {
        $this->time = $time;
    }
    public function getIsCurrent()
    {
        return $this->isCurrent;
    }
    public function setIsCurrent($isCurrent): void
    {
        $this->isCurrent = $isCurrent;
    }
}