<?php
//load database
require_once 'db.php';
?>

<html>

<head>
    <link rel="stylesheet" href="index.css" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <center>
        <!-- Middle section -->
        <div id="lg2">
            <div id="lg1">Login</div>
            <!-- Login section -->
            <div id="lg21">
                <a href="clogin.php">
                    <div class="lg211">
                        <img src="./images/avatar.png" alt="avatar" width="50%" />
                        Customer
                    </div>
                </a><a href="slogin.php">
                    <div class="lg211">
                        <img src="./images/home.png" alt="sal" width="50%" /> Salon
                    </div>
                </a>
            </div>
            <!-- Create Account section -->
            <div id="lg22">
                <a href="scna.php" class="lg221">Create Customer <br> Account</a>
                <a href="ccna.php" class="lg221">Create Salon <br> Account</a>
            </div>
        </div>
    </center>
</body>

</html>