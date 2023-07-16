<?php
//load database
require_once 'db.php';

$username = $cpassword = '';
//get action for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  $username = $_POST['username'];
  $cpassword = $_POST['password'];

  $sql = 'SELECT cid,email,phone,name,password from customer WHERE username=:username';
  if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    if ($stmt->execute()) {
      if ($stmt->rowCount() === 1) {
        if ($row = $stmt->fetch()) {
          $pass = $row['password'];
          if ($cpassword === $pass) {
            session_start();
            //Add to session memory
            $_SESSION['cid'] = $row['cid'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phone'] = $row['phone'];
            header('location:cdash.php');
          } else {
            echo ("password error");
          }
        }
      } else {
        echo ("username error");
      }
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
  <link rel="stylesheet" href="clogin.css" />
  <title>Login</title>
</head>

<body>
  <center>
    <div id="lg2">
      <div id="lg21">
        <a href="index.php"><img id="lg211" src="./images/arrow.png" alt="sal" height="100%" /></a>
      </div>
      <!-- Login -->
      <div id="lg1">Customer Login</div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="lg22">
        <label for="fname" class="txtnm">Username</label><br />
        <input type="text" name="username" value="" class="txtfld" /><br /><br />
        <label for="lname" class="txtnm">Password</label><br />
        <input type="password" name="password" value="" class="txtfld" /><br /><br /><br /><br />
        <!-- Submit form -->
        <input type="submit" class="lg221" value="LOGIN" />
      </form>
    </div>
  </center>
</body>

</html>