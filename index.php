<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login page</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>
        <div class="page-container">
            <?php include 'operations.php'; ?>
            <div class="page-title">
                <div class="page-title-text">
                    Jade's login
                </div>
            </div>
            <div class="page-login active" id="mainView">
                <div class="page-login-boxes">
                    <div class="page-login-boxes-username">
                        <input type="text" id="login-txtbox-username" name="txtbox-username" placeholder="Username...">
                    </div>
                    <div class="page-login-boxes-password">
                        <input type="password" id="login-txtbox-password" name="txtbox-password" placeholder="Password..." >
                    </div>
                </div>
                <div class="page-login-button-container">
                    <button id="button-login" name="button-login">login</button>
                    <button id="button-register-toggle" name="button-register">register</button>
                </div>
            </div>

            <div class="page-register" id="alternateView">
                <div class="page-register-boxes">
                    <div class="page-register-boxes-username">
                        <input type="text" id="register-txtbox-username" placeholder="Username...">
                    </div>
                    <div class="page-register-boxes-email">
                        <input type="text" id="register-txtbox-email" placeholder="Email...">
                    </div>
                    <div class="page-register-boxes-password">
                        <input type="password" id="register-txtbox-password" placeholder="Password...">
                    </div>
                </div>
                <div class="page-register-button">
                    <button id="button-register" name="button-register">Register</button>
                    <button id="button-register-back" name="button-register-back">Back to login</button>
                </div>
            </div>
            
            <div id=<?php echo $status_css; ?>><?php echo $status; ?></div>
            <div id="result"></div>
            <div id="username-text"></div>
        </div>

        <script src="javascript.js"></script>
    </body>
</html>