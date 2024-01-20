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
    <!-- <link rel="stylesheet" href="public/css/style.css"> -->
    <link rel="stylesheet" href="public\css\navbar.css">
    <link rel="stylesheet" href="public/css/location.css">
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

            <div class="main-frame">
                <div class="text-area">
                    <p>Welcome <?php echo $_SESSION["username"]?>!</p>
                    <p>Choose your location</p>
                </div>
                <div class="user-logo-area"><img src="<?php echo $avatar; ?>" alt=""></div>
                <div class="location-input-area">
                    <div class="btn"><button id="get-curr-location">Use my current location</button></div>
                    <div class="input"><input type="text" id="locationInput" placeholder="Enter a location" spellcheck="false"></div>
                    <div class="location"><button id="get-location-btn" role="button">Get Location</button></div>
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
    <script src="..\scripts\weather.js"></script>
</body>