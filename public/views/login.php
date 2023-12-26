<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/ee62767aeb.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login wrapper">
        <div class="brand-wrapper"><img src="public/img/logo.png" alt="" class="logo-near-brand-name">
            <p class="brand-name">What2Wear Wizard</p>
        </div>
        <aside class="left"><img src="public/img/nowy-wizard.png" alt=""></aside>
        <div class="flip-container">
            <div class="flipper" id="flipper">
                <aside class="right">
                    <img src="public/img/logo.png" alt="" class="logo">
                    <form class="login-form" action="login" method="POST">
                        <h3>Login Here</h3>
                        <div class="messages" style="margin-top: 20px; color: red">
                            <?php
                            if(isset($messages)){
                                foreach($messages as $message) {
                                    echo $message;
                                }
                            }
                            ?></div>
                        <label for="username">Username</label>
                        <input name="username" type="text" placeholder="Username" id="username">

                        <label for="password">Password</label>
                        <input name="password" type="password" placeholder="Password" id="password">

                        <button type="submit">Log In</button>
                        <a href="#" class="forgot-passwd">forgot password?</a>
                        <a href="#" class="sign-up flipbutton" id="loginButton">Click here to sign up</a>
                    </form>
                    <img src="public/img/mobile-wizard.png" alt="" class="wizard-mobile-down">
                </aside>
                <aside class="right-back">
                    <img src="public/img/logo.png" alt="" class="logo">
                    <form class="register-form">
                        <h3>Create account</h3>
                        <label for="username">Username</label>
                        <input name="username" type="text" placeholder="Username" id="username">

                        <label for="username">Email</label>
                        <input name="email" type="text" placeholder="Email" id="email">

                        <label for="password">Password</label>
                        <input name="password" type="password" placeholder="Password" id="password">

                        <label for="password">Confirm Password</label>
                        <input name="password" type="password" placeholder="Confirm Password" id="password">

                        <button>Register</button>
                        <a href="#" class="sign-up flipbutton" id="registerButton">Already has an account? Sign in</a>
                    </form>
                    <img src="public/img/mobile-wizard.png" alt="" class="wizard-mobile-down">
                </aside>
            </div>
        </div>
    </div>

    <script src="scripts/script.js"></script>
</body>

</html>