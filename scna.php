<?php
//load database
require_once 'db.php';

$nname = $email = $phone = $username = $cpassword = '';
//get action for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $nname = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $cpassword = $_POST['password'];

    $sql = 'INSERT INTO customer VALUES ( null,:nname, :email, :phone, :username, :cpassword)';
    if ($stmt = $pdo->prepare($sql)) {
        //binding php variables to sql
        $stmt->bindParam(':nname', $nname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
        //execute sql command
        if ($stmt->execute()) {
            header('location:clogin.php');
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
    <link rel="stylesheet" href="scna.css" />
    <title>Login</title>
</head>

<body>
    <center>

        <div id="lg2">
            <!-- Middle window-->
            <div id="lg21">
                <a href="index.php"><img id="lg211" src="./images/arrow.png" alt="sal" height="75%" /></a>
            </div>
            <br>
            <div id="lg1">Create Customer Account</div>


            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="lg22">
                <div id="lg221">
                    <label for="fname" class="txtnm">Name</label><br /><br />
                    <input type="text" name="name" value="" class="txtfld" /><br />
                </div>
                <br />
                <div id="lg222">
                    <div class="lg2221">
                        <label for="lname" class="txtnm">Email</label><br />
                        <input type="text" name="email" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Username</label><br />
                        <input type="text" name="username" value="" class="txtfld2" />
                    </div>
                    <div class="lg2221">
                        <label for="lname" class="txtnm">Phone</label><br />
                        <input type="text" name="phone" value="" class="txtfld2" /><br /><br />
                        <label for="lname" class="txtnm">Password</label><br />
                        <input type="password" name="password" value="" class="txtfld2" />
                    </div>
                </div>
                <!-- form submission-->
                <input type="submit" class="lg223" value="Create Account" />
                <br>
            </form>


        </div>
    </center>
</body>

</html>