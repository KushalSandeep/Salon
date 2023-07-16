<?php
//load database
require_once 'db.php';

$sname = $email = $phone = $username = $cpassword = '';
//get action for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $sname = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $cpassword = $_POST['password'];
    $address = $_POST['address'];

    $sql = 'INSERT INTO salon VALUES ( null,:nname, :email, :phone, :address , :username, :cpassword)';
    if ($stmt = $pdo->prepare($sql)) {
        //binding php variables to sql
        $stmt->bindParam(':nname', $sname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);

        //execute sql command
        if ($stmt->execute()) {
            header('location:slogin.php');
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
    <link rel="stylesheet" href="ccna.css" />
    <title>Login</title>
</head>

<body>
    <center>
        <!-- Middle window-->

        <div id="lg2">
            <div id="lg21">
                <a href="index.php"><img id="lg211" src="./images/arrow.png" alt="sal" height="75%" /></a>
            </div>
            <br><br>
            <div id="lg1">Create Salon Account</div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="lg22">
                <div id="lg222">
                    <div class="lg2221">
                        <label for="lname" class="txtnm">Salon Name</label><br />
                        <input type="text" name="name" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Phone</label><br />
                        <input type="text" name="phone" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Username</label><br />
                        <input type="text" name="username" value="" class="txtfld2" />
                    </div>
                    <div class="lg2221">
                        <label for="lname" class="txtnm">Email</label><br />
                        <input type="text" name="email" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Address</label><br />
                        <input type="text" name="address" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Password</label><br />
                        <input type="password" name="password" value="" class="txtfld2" />
                    </div>
                </div>
                <!-- form submission-->
                <input type="submit" class="lg223" value="Create Account" />
            </form>
            <br><br>
        </div>
    </center>
</body>

</html>