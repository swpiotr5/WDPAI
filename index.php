<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);
Routing::get('', 'DefaultController');
Routing::get('location', 'DefaultController');
Routing::get('active', 'DefaultController');
Routing::get('wardrobe', 'DefaultController');
Routing::get('userpage', 'DefaultController');
Routing::get('forecast', 'DefaultController');
Routing::get('forecast', 'WeatherController');
Routing::get('active', 'ActivityController');
Routing::get('userpage', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('deleteForecasts', 'ForecastController');
Routing::post('addForecast', 'ForecastController');
Routing::post('assignClothesToUser', 'WeatherController');
Routing::post('getAllClothes', 'ClothingController');
Routing::post('updateAvatar', 'SecurityController');
Routing::post('addNameToDatabase', 'SecurityController');
Routing::post('deleteUser', 'SecurityController');


Routing::run($path);