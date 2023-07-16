<?php
session_start();
require_once 'db.php';
if ($_SESSION['username'] == null) {
    header('location:index.php');
}

if (isset($_GET['search'])) {
    //get the number of rows in the salon table
    $pattern = '%' . $_GET['search'] . '%';
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT COUNT(*) from salon WHERE salonname LIKE :namee');
    $stmt->bindParam(':namee', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetch();
    $cnm = $count['0'];
    unset($stmt);

    //import data form salon table
    $stmt = $pdo->prepare('SELECT id,salonname,address from salon WHERE salonname LIKE :namee');
    $stmt->bindParam(':namee', $pattern, PDO::PARAM_STR);
    $stmt->execute();
    $a = array();
    $b = array();
    $c = array();
    for ($x = 0; $x < $cnm; $x++) {
        $saln = $stmt->fetch();
        array_push($a, $saln['id']);
        array_push($b, $saln['salonname']);
        array_push($c, $saln['address']);

    }

} else {
    //get the number of rows in the salon table
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT COUNT(*) from salon');
    $stmt->execute();
    $count = $stmt->fetch();
    $cnm = $count['0'];
    unset($stmt);

    //import data form salon table
    $stmt = $pdo->prepare('SELECT id,salonname,address from salon');
    $stmt->execute();
    $a = array();
    $b = array();
    $c = array();
    for ($x = 0; $x < $cnm; $x++) {
        $saln = $stmt->fetch();
        array_push($a, $saln['id']);
        array_push($b, $saln['salonname']);
        array_push($c, $saln['address']);

    }
}






?>

<html>

<head>
    <link rel="stylesheet" href="cdash.css" />
    <title>SALONS</title>
</head>

<body>
    <!-- Manu bar -->
    <div id="dash">
        <div id="ds1">
            <a href="cdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
        </div>
        <div id="ds2">
            <!-- search bar -->
            <div id="searchbar">
                <div id="sb1">
                    <input type="text" id="fname" name="rslt" placeholder="Search Salon..." class="txtfld" />
                </div>
                <a href='cdash.php'
                    onclick="location.href=this.href+'?search='+document.getElementsByName('rslt')[0].value; return false;"
                    id="sb2">
                    <img src="./images/search1.gif" alt="" width="60%" />
                </a>
            </div>
        </div>
        <div id="ds3">
            <img src="./images/menu2.png" alt="" width="100%" id="img2" />
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="bookings.php">Booking</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <!-- Display salons -->
    <div id="jadd">Salons</div>
    <div id="dbd">


        <div id="card">
            <a href="salonpg.php"><img src="./images/wall4.jpg" alt="" width="100%" /> Salon Name</a>
        </div>
    </div>

    <div id="srst">No Salons Found...</div>
    <script>
        //Create new element to display salons

        function myFunction(i, j, k) {
            const node = document.getElementById("card");
            const clone = node.cloneNode(true);
            clone.style.display = "block";
            clone.innerHTML =
                '<a href="salonpg.php?name=' + i + '"><img src="./images/wall4.jpg" alt="" width="100%"> <br/>' +
                j + '<br/><div id="abcd">' + k +
                "</div></a>";

            document.getElementById("dbd").appendChild(clone);
        }

        function myFunction2() {
            document.getElementById("srst").style.display = "block";

        }
        //assign values from php to javascript
        var passedArray = <?php echo json_encode($a); ?>;
        var passedArray2 = <?php echo json_encode($b); ?>;
        var passedArray3 = <?php echo json_encode($c); ?>;


        for (let i = 0; i < <?php echo $cnm; ?>; i++) {
            myFunction(passedArray[i], passedArray2[i], passedArray3[i]);
        }

        if (<?php echo $cnm; ?> == 0) {
            myFunction2();
        }
    </script>
</body>

</html>