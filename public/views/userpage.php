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
    <link rel="stylesheet" href="public\css\user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/ee62767aeb.js" crossorigin="anonymous"></script>
</head>

<body>
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
            <div class="user-data">
                <img src="<?php echo $avatar; ?>" alt="" class="user-image">
                <p class="username">username: <?php echo $_SESSION["username"] ?></p>
                <p class="email">email: <?php echo $_SESSION["email"]?></p>
                <button class="btn-user pwd-change" role="button">change your password</button>
                <form action="logout" method="post"><button type="submit" class="btn-user logout" role="button" onclick="window.location.href = '/';">logout</button></form>
                
            </div>
            <div class="avatar-section">
                <p>Choose your avatar</p>
                <div class="avatars">
                    <div class="avatar user"><img src="public\img\user.png" alt=""></div>
                    <div class="avatar nerd"><img src="public\img\nerd.png" alt=""></div>
                    <div class="avatar nerdwoman"><img src="public\img\nerduwa.png" alt=""></div>
                    <div class="avatar gamergirl"><img src="public\img\gamerka.png" alt=""></div>
                    <div class="avatar kid-boy"><img src="public\img\kidos.png" alt=""></div>
                    <div class="avatar kid-girl"><img src="public\img\kidos2.png" alt=""></div>
                    <div class="avatar grandpa"><img src="public\img\dziadek.png" alt=""></div>
                    <div class="avatar grandma"><img src="public\img\babka.png" alt=""></div>
                </div>
            </div>
        </div>
        <footer>
            <div class="wrapper-footer">
                <p>What2Wear Wizard</p><img src="public\img\logo.png" alt="">
            </div>
        </footer>
    </div>


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
    <script src="..\scripts\setAvatar.js"></script>
</body>