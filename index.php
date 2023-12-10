<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index','DefaultController');
Routing::get('forecast', 'DefaultController');
Routing::Get('location', 'DefaultController');
Routing::Get('active', 'DefaultController');
Routing::Get('wardrobe', 'DefaultController');
Routing::run($path);