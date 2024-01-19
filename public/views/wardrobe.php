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
    <link rel="stylesheet" href="public\css\wardrobe.css">
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
                <div class="text-section">Select your clothes</div>
                <div class="clothing-section">
                    <div class="clothes">
                        <input type="radio" id="raincoat" name="raincoat" value="raincoat">
                        <div class="item">
                            <label for="raincoat">
                                <img src="public\img\raincoat.png" alt="">
                            </label>
                            <p>raincoat</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="trench-coat" name="trench-coat" value="trench-coat">
                        <div class="item">
                            <label for="trench-coat">
                                <img src="public\img\trench-coat.png" alt="">
                            </label>
                            <p>trench coat</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="woolen-coat" name="woolen-coat" value="woolen-coat">
                        <div class="item">
                            <label for="woolen-coat">
                                <img src="public\img\woolen-coat.png" alt="">
                            </label>
                            <p>woolen coat</p>
                        </div></div>
                    <div class="clothes">
                        <input type="radio" id="denim-jacket" name="denim-jacket" value="denim-jacket">
                        <div class="item">
                            <label for="denim-jacket">
                                <img src="public\img\denim-jacket.png" alt="">
                            </label>
                            <p>denim jacket</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="down-jacket" name="down-jacket" value="down-jacket">
                        <div class="item">
                            <label for="down-jacket">
                                <img src="public\img\down-jacket.png" alt="">
                            </label>
                            <p>down jacket</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="bomber-jacket" name="bomber-jacket" value="bomber-jacket">
                        <div class="item">
                            <label for="bomber-jacket">
                                <img src="public\img\bomber-jacket.png" alt="">
                            </label>
                            <p>bomber jacket</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="turtleneck" name="turtleneck" value="turtleneck">
                        <div class="item">
                            <label for="turtleneck">
                                <img src="public\img\turtleneck.png" alt="">
                            </label>
                            <p>turtleneck</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="sweatshirt" name="sweatshirt" value="sweatshirt">
                        <div class="item">
                            <label for="sweatshirt">
                                <img src="public\img\sweatshirt.png" alt="">
                            </label>
                            <p>sweatshirt</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="sweater" name="sweater" value="sweater">
                        <div class="item">
                            <label for="sweater">
                                <img src="public\img\sweater.png" alt="">
                            </label>
                            <p>sweater</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="tshirt" name="tshirt" value="tshirt">
                        <div class="item">
                            <label for="tshirt">
                                <img src="public\img\tshirt.png" alt="">
                            </label>
                            <p>tshirt</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="longsleeve" name="longsleeve" value="longsleeve">
                        <div class="item">
                            <label for="longsleeve">
                                <img src="public\img\longsleeve.png" alt="">
                            </label>
                            <p>longsleeve</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="shirt" name="shirt" value="shirt">
                        <div class="item">
                            <label for="shirt">
                                <img src="public\img\shirt.png" alt="">
                            </label>
                            <p>shirt</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="trousers" name="trousers" value="trousers">
                        <div class="item">
                            <label for="trousers">
                                <img src="public\img\trousers.png" alt="">
                            </label>
                            <p>trousers</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="sweatpants" name="sweatpants" value="sweatpants">
                        <div class="item">
                            <label for="sweatpants">
                                <img src="public\img\sweatpants.png" alt="">
                            </label>
                            <p>sweatpants</p>
                        </div>
                    </div>
                    <div class="clothes">
                        <input type="radio" id="shorts" name="shorts" value="shorts">
                        <div class="item">
                            <label for="shorts">
                                <img src="public\img\shorts.png" alt="">
                            </label>
                            <p>shorts</p>
                        </div>
                    </div>
                </div>
                <button id="save-clothes-btn">Save</button>
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

        var clothesInputs = document.querySelectorAll('.clothing-section .clothes input[type="radio"]');

        clothesInputs.forEach(function(input) {
            input.addEventListener('click', function() {
                if (this.classList.contains('checked')) {
                    this.checked = false;
                    this.classList.remove('checked');
                } else {
                    this.classList.add('checked');
                }
            });
        });

        document.getElementById('save-clothes-btn').addEventListener('click', function() {
            var selectedClothes = [];
            
            clothesInputs.forEach(function(input) {
                if (input.checked) {
                    selectedClothes.push(input.value);
                }
            });
            console.log(selectedClothes);

            fetch('/getAllClothes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(dataArray => {
                selectedClothes.forEach(function(clothing) {
                    dataArray.forEach(function(data) {
                        if (data.clothing_type === clothing) {
                            console.log('Selected clothing found in server data:', data);
                        }
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>