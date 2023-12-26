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
            <div class="text-info">
                <p>proposed activity</p>
            </div>
            <div class="activities">
                <div class="activity"></div>
                <div class="activity"></div>
                <div class="activity"></div>
                <div class="activity"></div>
                <div class="activity"></div>
                <div class="activity"></div>
            </div>
            <div class="note-info">
                <div class="note">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt quos tenetur ab illo est totam
                        consequuntur nisi? Hic sint nulla, quaerat unde ab obcaecati nesciunt vero quod, repellendus
                        labore error!
                        Tempore magnam voluptatum sed voluptate recusandae nesciunt et perspiciatis asperiores
                        expedita, aut ipsum cupiditate incidunt quam. Enim ex aperiam ut quisquam ratione aut iusto?
                        Rerum nemo dicta dolore ducimus magnam!
                    </p>
                </div>
            </div>

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