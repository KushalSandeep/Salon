<?php
//load database
session_start();
require_once 'db.php';

//delete booking
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE from customer WHERE cid=:id');
    $stmt->bindParam(':id', $_SESSION['cid'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);
    $stmt = $pdo->prepare('DELETE from book WHERE cid=:id');
    $stmt->bindParam(':id', $_SESSION['cid'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);
    header('location:index.php');
    echo '<script>alert("Account deleted")</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sname = $email = $phone = '';
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $sname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $_SESSION['username'] = trim($sname);
    $_SESSION['email'] = trim($email);
    $_SESSION['phone'] = trim($phone);



    $sql = 'UPDATE customer SET name=:nname, email=:email, phone=:phone WHERE cid=:id';
    if ($stmt = $pdo->prepare($sql)) {
        //binding php variables to sql
        $stmt->bindParam(':id', $_SESSION['cid'], PDO::PARAM_STR);
        $stmt->bindParam(':nname', $sname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        //execute sql command
        if ($stmt->execute()) {
            header('location:profile.php');
        } else {
            die('something went wrong');
        }
        unset($stmt);
    }
    unset($pdo);
}

?>



<html>

<head>
    <link rel="stylesheet" href="profile.css" />
    <title>Login</title>
</head>
<!-- Menu bar -->

<body>
    <div id="dash">
        <div id="ds1">
            <a href="cdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
        </div>
        <div id="ds2">Profile</div>
        <div id="ds3">
            <img src="./images/menu2.png" alt="" width="100%" id="img2" />
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="bookings.php">Booking</a>
                <a href="index.php">Logout</a>
            </div>
        </div>
    </div>
    <!-- Middle section card-->
    <div id="dbd">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="card">
            <div id="lg221">
                <label for="fname" class="txtnm">Name</label><br /><br />
                <input type="text" id="fname" name="name" value="<?php echo ' ' . $_SESSION['username'] ?>"
                    class="txtfld" /><br />
            </div><br>
            <div id="lg221">
                <label for="fname" class="txtnm">Email</label><br /><br />
                <input type="text" id="fname" name="email" value="<?php echo ' ' . $_SESSION['email'] ?>"
                    class="txtfld" /><br />
            </div><br>
            <div id="lg221">
                <label for="fname" class="txtnm">Phone</label><br /><br />
                <input type="text" id="fname" name="phone" value="<?php echo ' ' . $_SESSION['phone'] ?>"
                    class="txtfld" /><br />
            </div>
            <!-- submit button -->
            <input type="submit" class="lg223" value="Save" />
        </form>
        <a href='profile.php?delete=true' id="del">Delete Acc</a>
    </div>
</body>

</html>