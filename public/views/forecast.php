<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login"); // Przekieruj na stronę logowania, jeśli użytkownik nie jest zalogowany
    exit;
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
                <div class="user-logo"><a href="userpage"><img src="public\img\user.png" alt=""></a></div>
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
                    <p class="city">Kraków</p>
                    <p class="weather-info">6°C | rain soon</p>
                </div>
                <div class="temperatures">
                    <div class="weather-container"><p class="time">Now</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                    <div class="weather-container"><p class="time">9AM</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                    <div class="weather-container"><p class="time">12PM</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                    <div class="weather-container"><p class="time">15PM</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                    <div class="weather-container"><p class="time">18PM</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                    <div class="weather-container"><p class="time">21PM</p><img src="public\img\weather-cloud.png" alt=""><p class="temperature">9℃</p></div>
                </div>
                <div class="other-parameters">
                    <div class="parameter sunrise"><img src="public\img\sunrise.png" alt=""><p class="time">6AM</p></div>
                    <div class="parameter sunset"><img src="public\img\sunset.png" alt=""><p class="time">2PM</p></div>
                    <div class="parameter wind-speed"><img src="public\img\wind.png" alt=""><p class="speed">16m/s</p></div>
                    <div class="parameter humidity"><img src="public\img\humidity.png" alt=""><p class="humidity-text">91%</p></div>
                    <div class="parameter rain-chance"><img src="public\img\rain.png" alt=""><p class="rain-text">0%</p></div>
                    <div class="parameter pressure"><img src="public\img\pressure.png" alt=""><p class="pressure-text">1010hPa</p></div>
                </div>
                <div class="clothing-info">
                    <p>clothing suggestions</p>
                    <div class="clothing-wrapper">                    
                        <div class="clothing"></div>
                        <div class="clothing"></div>
                        <div class="clothing"></div>
                        <div class="clothing"></div>
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