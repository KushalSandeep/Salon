<?php
//load database
session_start();
require_once 'db.php';
if ($_SESSION['username'] == null) {
    header('location:index.php');
}



$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$idd = trim($_GET['name']);
if (isset($_SESSION['iddd'])) {
    $_SESSION['iddd'] = $idd;
}

//select all data from salon table
$stmt = $pdo->prepare('SELECT * from salon where id=:nam');
$stmt->bindParam(':nam', $idd, PDO::PARAM_STR);
$stmt->execute();
$saln = $stmt->fetch();
unset($stmt);

//select all data from service table
$stmt = $pdo->prepare('SELECT * from service where id=:nam');
$stmt->bindParam(':nam', $idd, PDO::PARAM_STR);
$stmt->execute();
$srcn = $stmt->fetch();
unset($stmt);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//count all data from salon table
$stmt = $pdo->prepare('SELECT COUNT(*) from service WHERE id=:id');
$stmt->bindParam(':id', $idd, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetch();
$cnm = $count['0'];
unset($stmt);

//assign salon data to arrays 
$stmt = $pdo->prepare('SELECT services,price from service WHERE id=:id');
$stmt->bindParam(':id', $idd, PDO::PARAM_STR);
$stmt->execute();
$a = array();
$b = array();
for ($x = 0; $x < $cnm; $x++) {
    $salnn = $stmt->fetch();
    array_push($a, $salnn['0']);
    array_push($b, $salnn['1']);
}
unset($stmt);

$servicen = $date = $hour = $minute = $tst = '';
//Add Booking section
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $servicen = $_POST['optn'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $minute = $_POST['min'];


    //insert data into the database
    $sql = 'INSERT INTO book VALUES ( null,:id, :cid, :service, :date, :hour, :min )';
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $idd, PDO::PARAM_STR);
        $stmt->bindParam(':cid', $_SESSION['cid'], PDO::PARAM_STR);
        $stmt->bindParam(':service', $servicen, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':hour', $hour, PDO::PARAM_STR);
        $stmt->bindParam(':min', $minute, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header('location:bookings.php');

        } else {
            die('something went wrong');
        }
        unset($stmt);
    }
    unset($pdo);
    unset($_SESSION['iddd']);

}


?>

<html>

<head>
    <link rel="stylesheet" href="salonpg.css" />
    <title>Login</title>
    <script>
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    var name = getParameterByName('name');
    </script>
</head>

<body>
    <div id="dash">
        <div id="dash2">
            <div id="ds1">
                <!-- Salon image -->
                <a href="cdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
            </div>
            <div id="ds2">
                <?php echo $saln[1] ?>
            </div>
            <!-- Dropdown Menu -->
            <div id="ds3">
                <img src="./images/menu2.png" alt="" width="100%" id="img2" />
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="bookings.php">Booking</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>

    </div>
    <img src="./images/wall6.jpg" alt="" width="100%">
    <!-- Salon booking card (initially hidden) -->
    <div id="card">
        <div class="close" onclick="hidep()"></div>
        <form action="salonpg.php?name=<?php echo $idd; ?>" method="POST" id="hahah">
            <!-- booking elements -->
            <div class="con1"><label for="lname">Salon</label>
                <br />
                <input type="text" name="sname" value="<?php echo $saln[1] ?>" id="lnd" />
            </div>

            <div class="con1"><label for="lname">Service</label>
                <br />
                <select name="optn" id="lnd4">
                    <option value="">Select Service..</option>
                    <?php for ($y = 0; $y < $cnm; $y++) {
                        echo '<option value="' . $a[$y] . '" >' . $a[$y] . '  :    Rs.' . $b[$y] . '</option>';
                    }

                    ?>
                </select>
            </div>

            <div class="con1"><label for="lname">Date</label>
                <br />
                <input type="date" name="date" value="" id="lnd3" />
            </div>
            <div class="con1"><label for="lname">Time</label>
                <select name="hour" id="lnd2">
                    <option value="0" id="optionn">Hour</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                </select>
                <select name="min" id="lnd2">
                    <option value="0" id="optionn">Minute</option>
                    <option value="00">00</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select>
            </div>
            <input type="submit" id="btnn" value="Save" />

        </form>
    </div>
    <div id="dbd">
        <div class="details">
            <!-- Salon details card -->
            <div id="topic"><b>Salon Details</b></div>
            <div id="set">
                <div id="data">Name:
                    <?php echo $saln[1] ?>
                </div>
                <div id="data">Email:
                    <?php echo $saln[2] ?>
                </div>
                <div id="data">Phone No:
                    <?php echo $saln[3] ?>
                </div>
                <div id="data">Address:
                    <?php echo $saln[4] ?>
                </div>
            </div>
        </div>
        <!-- Services card -->
        <div class="details">
            <div id="topic"><b>Services and Prices</b></div>
            <div id="set2">
                <div id="data"></div>
            </div>
        </div>
    </div>
    <br /><br /><br />
    <div id="btnn" onclick="showp()">Book</div>
    <br /><br /><br />
    <script>
    function showp() {
        document.getElementById("card").style.display = "block";
    }

    function hidep() {
        document.getElementById("card").style.display = "none";
    }

    function myFunction(i, j) {
        const node = document.getElementById("data");
        const clone = node.cloneNode(true);
        clone.innerHTML = '<div id="data">' + i + ' - ' + j + '</div>';
        document.getElementById("set2").appendChild(clone);
    }



    function myFunction2() {
        const node = document.getElementById("data");
        const clone = node.cloneNode(true);
        clone.innerHTML = '<div id="data">No services </div>';
        document.getElementById("set2").appendChild(clone);
    }

    if (<?php echo $cnm; ?> == 0) {
        myFunction2();
    }


    var passedArray = <?php echo json_encode($a); ?>;
    var passedArray2 = <?php echo json_encode($b); ?>;

    for (let i = 0; i < <?php echo $cnm; ?>; i++) {
        myFunction(passedArray[i], passedArray2[i]);
    }
    </script>




</body>

</html>