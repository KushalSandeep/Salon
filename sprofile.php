<?php
//load database
require_once 'db.php';
session_start();
$servicename = $price = '';

//delete profile
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE from salon WHERE id=:id');
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);

    $stmt = $pdo->prepare('DELETE from service WHERE id=:id');
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);

    $stmt = $pdo->prepare('DELETE from book WHERE id=:id');
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);

    header('location:index.php');
    echo '<script>alert("Account deleted")</script>';
}

//Add services to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'Update') {
        $sname = $email = $phone = $address = '';
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $sname = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $_SESSION['salonname'] = trim($sname);
        $_SESSION['email'] = trim($email);
        $_SESSION['phone'] = trim($phone);
        $_SESSION['address'] = trim($address);


        $sql = 'UPDATE salon SET salonname=:nname, email=:email, phone=:phone, address=:address WHERE id=:id';
        if ($stmt = $pdo->prepare($sql)) {
            //binding php variables to sql
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
            $stmt->bindParam(':nname', $sname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);

            //execute sql command
            if ($stmt->execute()) {
                header('location:sprofile.php');
            } else {
                die('something went wrong');
            }
            unset($stmt);
        }
        unset($pdo);
    } else {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $servicename = $_POST['sname'];
        $price = $_POST['price'];

        $sql = 'INSERT INTO service VALUES ( null,:id, :salonname, :services, :price )';
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
            $stmt->bindParam(':salonname', $_SESSION['salonname'], PDO::PARAM_STR);
            $stmt->bindParam(':services', $servicename, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header('location:sprofile.php');

            } else {
                die('something went wrong');
            }
            unset($stmt);
        }
        unset($pdo);
    }

}

//count existing services
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare('SELECT COUNT(*) from service WHERE id=:id');
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetch();
$cnm = $count['0'];
unset($stmt);

//get existing services from the database
$stmt = $pdo->prepare('SELECT services,price from service WHERE id=:id');
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
$stmt->execute();
$a = array();
$b = array();
for ($x = 0; $x < $cnm; $x++) {
    $saln = $stmt->fetch();
    array_push($a, $saln['0']);
    array_push($b, $saln['1']);
}
unset($stmt);



?>

<html>

<head>
    <link rel="stylesheet" href="sprofile.css" />
    <title>Login</title>
</head>

<body>
    <div id="dash">
        <div id="ds1">
            <a href="sdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
        </div>
        <div id="ds2">Salon Profile</div>
        <div id="ds3">
            <!-- Dropdown menu -->
            <img src="./images/menu2.png" alt="" width="100%" id="img2" />
            <div class="dropdown-content">
                <a href="sprofile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div id="dbd">
        <!-- profile form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="card">
            <div id="lg222">
                <div class="lg2221">
                    <label for="lname" class="txtnm"><b>Salon Name</b></label><br />
                    <input type="text" id="lname" name="name" value="<?php echo ' ' . $_SESSION['salonname'] ?>"
                        class="txtfld2" /><br /><br />
                </div>
                <div class="lg2221">
                    <label for="lname" class="txtnm"><b>Email</b></label><br />
                    <!-- Display data from database -->
                    <input type="text" id="lname" name="email" value="<?php echo ' ' . $_SESSION['email'] ?>"
                        class="txtfld2" /><br /><br />
                </div>
            </div>
            <div id="lg222">
                <div class="lg2221">
                    <label for="lname" class="txtnm"><b>Phone</b></label><br />
                    <input type="text" id="lname" name="phone" value="<?php echo ' ' . $_SESSION['phone'] ?>"
                        class="txtfld2" /><br /><br />
                </div>
                <div class="lg2221">
                    <label for="lname" class="txtnm"><b>Address</b></label><br />
                    <input type="text" id="lname" name="address" value="<?php echo ' ' . $_SESSION['address'] ?>"
                        class="txtfld2" /><br /><br />
                </div>
            </div>

            <div id="lg221">
                <br /><br /><br />
                <!-- Add new services -->
                <label for="lname" class="txtnm"><b>Add Services</b></label><br />
                <div id="txtfld3">
                    <input type="text" id="lname" name="sname" placeholder="Service Name" class="lts1" />
                    <input type="text" id="lname" name="price" placeholder="Price(Rs.)" class="lts2" />
                    <input type="submit" name="action" id="lts3" value="Add" />
                </div><br />
                <div id="clon">
                    <br /><br />
                    <!-- Display existing services -->
                    <label for="lname" class="txtnm"><b>Services</b></label>
                    <br />
                    <div id="txtfld">
                        <div id="lfd1">Name</div>
                        <div id="lfd2">Price</div>
                    </div>

                </div>
                <br><br>
            </div>

            <br>
            <input type="submit" name="action" class="lg223" value="Update" />


        </form>

    </div>


    <script>
        //create new elements
        function myFunction(i, j) {
            const node = document.getElementById("txtfld");
            const clone = node.cloneNode(true);
            clone.innerHTML = '<div id="lfd1">' + i + '</div> ' + '<div id="lfd2">Rs.' + j + '</div>';
            document.getElementById("clon").appendChild(clone);
        }

        var passedArray = <?php echo json_encode($a); ?>;
        var passedArray2 = <?php echo json_encode($b); ?>;

        for (let i = 0; i < <?php echo $cnm; ?>; i++) {
            myFunction(passedArray[i], passedArray2[i]);
        }
    </script>
    <a href='sprofile.php?delete=true' id="dell">Delete Acc</a>

</body>

</html>