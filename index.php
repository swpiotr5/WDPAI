<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('forecast', 'DefaultController');
Routing::get('location', 'DefaultController');
Routing::get('active', 'DefaultController');
Routing::get('wardrobe', 'DefaultController');
Routing::get('userpage', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('addForecast', 'ForecastController');
Routing::post('getAllClothes', 'ClothingController');
Routing::run($path);