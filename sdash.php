<?php
//load database
session_start();
require_once 'db.php';
if ($_SESSION['username'] == null) {
    header('location:index.php');
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//count number of bookings for the salon
$stmt = $pdo->prepare('SELECT COUNT(*) from book WHERE id=:id');
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetch();
$cnm = $count['0'];
unset($stmt);

//select all data relevent for the salon from the table
$stmt = $pdo->prepare('SELECT * from book WHERE id=:id');
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
$stmt->execute();
$a = array();
$b = array();
$c = array();
$d = array();
//pass value from sql to php arrays
for ($x = 0; $x < $cnm; $x++) {
    $salnn = $stmt->fetch();
    array_push($a, $salnn['cid']);
    array_push($b, $salnn['date']);
    array_push($c, $salnn['hour']);
    array_push($d, $salnn['min']);
}
unset($stmt);
$e = array();
$f = array();
$g = array();
for ($x = 0; $x < $cnm; $x++) {
    $stmt = $pdo->prepare('SELECT name,phone,email from customer WHERE cid=:id');
    $stmt->bindParam(':id', $a[$x], PDO::PARAM_STR);
    $stmt->execute();
    $asdd = $stmt->fetch();
    array_push($e, $asdd['name']);
    array_push($f, $asdd['phone']);
    array_push($g, $asdd['email']);
    unset($stmt);
}

?>

<html>

<head>
    <link rel="stylesheet" href="sdash.css" />
    <title>dashboard</title>
</head>

<body>
    <div id="dash">
        <div id="ds1">
            <a href="sdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
        </div>
        <!-- Dashboard -->
        <div id="ds2">dashboard</div>
        <!-- Dropdown menu -->
        <div id="ds3">
            <img src="./images/menu2.png" alt="" width="100%" id="img2" />
            <div class="dropdown-content">
                <a href="sprofile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <!-- Middle window -->
    <div id="dbd">
        <div id="card">
            <div id="line">Upcoming Appointments</div>
            <div id="linne">
                <div id="line4">
                    <div id="line1">Customer Name</div>
                    <div id="line2">date and time</div>
                    <div id="line3">view</div>
                </div>
            </div>

        </div>
    </div>
    <br>
    <div id="card2">
        <div class="close" onclick="hidep()"></div>
        <div id="nonn">
            <div id="nonn2">
                <label for="lname">Name :</label>
                <label for="lname">Date :</label>
                <label for="lname">Time :</label>
            </div>
        </div>

    </div>


    <script>
        function showp(a) {
            document.getElementById("card2").style.display = "block";
            myFunction3(a);
        }

        function hidep() {
            document.getElementById("card2").style.display = "none";
            const node = document.getElementById("nonn2");
            node.remove();
        }

        function myFunction3(a) {
            const node = document.getElementById("nonn");
            const clone = node.cloneNode(true);
            clone.style.display = "block";
            clone.innerHTML =
                '<div id="nonn"><div id="nonn2"><label for="lname">Name : ' + passedArray4[a] +
                '</label><label for="lname">Email : ' + passedArray6[a] + '</label><label for="lname">Phone No : ' +
                passedArray5[a] + '</label><label for="lname">Date : ' +
                passedArray[a] + '</label><label for="lname">Time : ' +
                passedArray2[a] + ':' + passedArray3[a] + '</label></div></div>';

            document.getElementById("nonn").replaceWith(clone);
        }

        //add new elements
        function myFunction(a, b, c, d, e) {
            const node = document.getElementById("linne");
            const clone = node.cloneNode(true);
            console.log(typeof c);
            clone.style.display = "block";
            clone.innerHTML =
                '<div id="line4"><div id="line1">' + d + '</div>' + '<div id = "line2"> ' + a + ' ~ ' + b + ':' + c +
                ' </div>' +
                '<div id = "line3" onclick="showp(' + e + ')"> view </div></div>';

            document.getElementById("card").appendChild(clone);
        }

        function myFunction2() {
            const node = document.getElementById("linne");
            const clone = node.cloneNode(true);
            clone.style.display = "block";
            clone.innerHTML =
                '<div id="line5">No Upcoming Appointments</div>';

            document.getElementById("card").appendChild(clone);
        }

        //pass values from php to sql
        var passedArray = <?php echo json_encode($b); ?>;
        var passedArray2 = <?php echo json_encode($c); ?>;
        var passedArray3 = <?php echo json_encode($d); ?>;
        var passedArray4 = <?php echo json_encode($e); ?>;
        var passedArray5 = <?php echo json_encode($f); ?>;
        var passedArray6 = <?php echo json_encode($g); ?>;

        if (<?php echo $cnm; ?> == 0) {
            myFunction2();
        }


        for (let i = 0; i < <?php echo $cnm; ?>; i++) {
            myFunction(passedArray[i], passedArray2[i], passedArray3[i], passedArray4[i], i);
        }
    </script>


</body>

</html>