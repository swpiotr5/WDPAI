<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login"); // Przekieruj na stronę logowania, jeśli użytkownik nie jest zalogowany
    exit;
}
if (isset($_SESSION['avatar'])) {
    $avatar = $_SESSION['avatar'];
} else {
    $avatar = 'public\img\user.png';
}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public\css\navbar.css">
    <link rel="stylesheet" href="public\css\forecast.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/ee62767aeb.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="wrapper">
            <div class="navbar">
                <div class="logo"><img src="public\img\logo.png" alt=""></div>
                <ul class="links">
                    <li><a href="forecast">forecast</a></li>
                    <li><a href="location">location</a></li>
                    <li><a href="active">active</a></li>
                    <li><a href="wardrobe">wardrobe</a></li>
                </ul>
                <div class="user-logo"><a href="userpage"><img src="<?php echo $avatar; ?>" alt=""></a></div>
                <div class="toggle-btn"><i class="fa-solid fa-bars"></i></div>
            </div>
            <div class="dropdown-menu">
                <li><a href="forecast">forecast</a></li>
                <li><a href="location">location</a></li>
                <li><a href="active">active</a></li>
                <li><a href="wardrobe">wardrobe</a></li>
                <li><a href="userpage">user</a></li>
            </div>
            <div class="main-section">
                <div class="banner">
                    <p class="city"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getCityName')) ? $current_forecast->getCityName() : ''; ?></p>
                    <p class="weather-info"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getTemperature')) ? $current_forecast->getTemperature() . '°C' : ''; ?> | <?php echo (isset($current_forecast) && method_exists($current_forecast, 'getPreciseWeatherDescription')) ? $current_forecast->getPreciseWeatherDescription() : ''; ?></p>
                </div>
                <div class="temperatures">
                    <div class="weather-container">
                        <p class="time">Now</p>
                        <img src="<?php echo (isset($current_forecast) && method_exists($current_forecast, 'getWeatherIconUrl')) ? $current_forecast->getWeatherIconUrl() : ''; ?>" alt="">
                        <p class="temperature"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getTemperature')) ? $current_forecast->getTemperature() . '℃' : ''; ?></p>
                    </div>
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="weather-container">
                            <p class="time"><?php echo (isset($future_forecasts[$i]) && method_exists($future_forecasts[$i], 'getTime')) ? $future_forecasts[$i]->getTime() : ''; ?></p>
                            <img src="<?php echo (isset($future_forecasts[$i]) && method_exists($future_forecasts[$i], 'getWeatherIconUrl')) ? $future_forecasts[$i]->getWeatherIconUrl() : ''; ?>" alt="">
                            <p class="temperature"><?php echo (isset($future_forecasts[$i]) && method_exists($future_forecasts[$i], 'getTemperature')) ? $future_forecasts[$i]->getTemperature() . '℃' : ''; ?></p>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="other-parameters">
                    <div class="parameter sunrise"><img src="public\img\sunrise.png" alt=""><p class="time"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getSunrise')) ? $current_forecast->getSunrise() : ''; ?></p></div>
                    <div class="parameter sunset"><img src="public\img\sunset.png" alt=""><p class="time"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getSunset')) ? $current_forecast->getSunset() : ''; ?></p></div>
                    <div class="parameter wind-speed"><img src="public\img\wind.png" alt=""><p class="speed"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getWind')) ? $current_forecast->getWind() . 'm/s' : ''; ?></p></div>
                    <div class="parameter humidity"><img src="public\img\humidity.png" alt=""><p class="humidity-text"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getHumidity')) ? $current_forecast->getHumidity() . '%' : ''; ?></p></div>
                    <div class="parameter rain-chance"><img src="public\img\rain.png" alt=""><p class="rain-text"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getRain')) ? $current_forecast->getRain() . 'mm' : ''; ?></p></div>
                    <div class="parameter pressure"><img src="public\img\pressure.png" alt=""><p class="pressure-text"><?php echo (isset($current_forecast) && method_exists($current_forecast, 'getPressure')) ? $current_forecast->getPressure() . 'hPa' : ''; ?></p></div>
                </div>
                <div class="clothing-info">
                    <p>clothing suggestions</p>
                    <div class="clothing-wrapper">
                        <?php foreach ($suggestedClothing as $clothingSet): ?>
                            <?php foreach ($clothingSet['clothing'] as $clothing): ?>
                                <div class="clothing">
                                    <img src="public/img/<?php echo strtolower($clothing); ?>.png" alt="<?php echo $clothing; ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="clothing-message clothing">
                            <?php foreach ($suggestedClothing as $clothingSet): ?>
                                <p><?php echo $clothingSet['message']; ?></p>
                            <?php endforeach; ?>
                        </div>
                </div>
            </div>
            <footer><div class="wrapper-footer"><p>What2Wear Wizard</p><img src="public\img\logo.png" alt=""></div></footer>
        </div>

    </header>

    <script>
        const toggleBtn = document.querySelector('.toggle-btn')
        const toggleBtnIcon = document.querySelector('.toggle-btn i')
        const dropDownMenu = document.querySelector('.dropdown-menu')

        toggleBtn.onclick = function () {
            dropDownMenu.classList.toggle('open')
            const isOpen = dropDownMenu.classList.contains('open')

            toggleBtnIcon.classList = isOpen
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars'

        }
    </script>
</body>