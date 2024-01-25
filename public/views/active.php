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
    <link rel="stylesheet" href="public\css\active.css">
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
            <div class="text-info">
                <p>proposed activity</p>
            </div>
            <div class="activities" style="<?php echo !isset($suggestedActivities) ? 'display: none;' : ''; ?>">
            <?php foreach ($suggestedActivities as $activity): ?>
                <div class="activity"><p><?php echo $activity; ?></p></div>
            <?php endforeach; ?>
            </div>
            <div class="textinfo" style="<?php echo !isset($suggestedActivities) ? 'display: none;' : ''; ?>"><p><?php echo $message?></p></div>
            <div class="error-display" style="<?php echo isset($suggestedActivities) ? 'display: none;' : ''; ?>"><p class="errortext" style="color: aliceblue; font-size: 1.5rem; font-family: 'Roboto', sans-serif; text-align: center; margin-top: 50px;">PLEASE SPECIFY YOUR LOCATION FIRST</p><img src="public\img\wizard-waiting.png" alt=""></div>


        </div>
        <footer><div class="wrapper-footer"><p>What2Wear Wizard</p><img src="public\img\logo.png" alt=""></div></footer>
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
</body>