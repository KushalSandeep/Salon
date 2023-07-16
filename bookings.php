<?php
//load database
require_once 'db.php';
session_start();

//getting the number of columns in the book table for the user
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare('SELECT COUNT(*) from book WHERE cid=:id');
$stmt->bindParam(':id', $_SESSION['cid'], PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetch();
$cnm = $count['0'];
unset($stmt);

//import all booking data from booking table
$stmt = $pdo->prepare('SELECT * from book WHERE cid=:id');
$stmt->bindParam(':id', $_SESSION['cid'], PDO::PARAM_STR);
$stmt->execute();
$a = array();
$b = array();
$c = array();
$d = 0;
$ee = 0;
$e = array();
$f = array();
$g = array();
$gh = array();
$lh = array();
$gm = array();
$lm = array();
$gi = array();
$li = array();
$gn = array();
$ln = array();
$idt = array();
$idtg = array();
$idtl = array();

for ($x = 0; $x < $cnm; $x++) {
    $saln = $stmt->fetch();
    array_push($a, $saln['date']);
    array_push($e, $saln['id']);
    array_push($f, $saln['hour']);
    array_push($g, $saln['min']);
    array_push($idt, $saln['bid']);
}

unset($stmt);

//assign the imported values to arrays
for ($x = 0; $x < $cnm; $x++) {
    $dt = strtotime($a[$x]);
    $ww = getdate($dt);
    $stmt = $pdo->prepare('SELECT salonname from salon WHERE id=:id');
    $stmt->bindParam(':id', $e[$x], PDO::PARAM_STR);
    $stmt->execute();
    $nm = $stmt->fetch();
    if ((int) $ww['mon'] <= (int) date("m") && (int) $ww['mday'] < (int) date("d")) {
        array_push($b, $a[$x]);
        array_push($lh, $f[$x]);
        array_push($lm, $g[$x]);
        array_push($ln, $nm['0']);
        array_push($idtl, $idt[$x]);
        $d = $d + 1;
    } else {
        array_push($c, $a[$x]);
        array_push($gh, $f[$x]);
        array_push($gm, $g[$x]);
        array_push($gn, $nm['0']);
        array_push($idtg, $idt[$x]);
        $ee = $ee + 1;
    }
}
//delete booking
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE from book WHERE bid=:id');
    $stmt->bindParam(':id', $_GET['delete'], PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);
    header('location:bookings.php');
}

?>

<html>

<head>
    <link rel="stylesheet" href="bookings.css" />
    <title>Login</title>
</head>

<body>
    <!-- Dashboard -->
    <div id="dash">
        <div id="ds1">
            <a href="cdash.php"><img src="./images/icon1.png" alt="" width="40%" id="img1" /></a>
        </div>
        <div id="ds2">My Bookings</div>
        <div id="ds3">
            <!-- Menu bar -->
            <img src="./images/menu2.png" alt="" width="100%" id="img2" />
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="bookings.php">Booking</a>
                <a href="index.php">Logout</a>
            </div>
        </div>
    </div>
    <div id="dbd">
        <!-- middle section of the body -->
        <div id="card">
            <div id="sec1">
                <div id="line">
                    <div id="cont">
                        <!-- Available booking list -->
                        <div id="line1">Salon name</div>
                        <div id="line2">date and time</div>
                        <div id="line3">view</div>
                    </div>

                </div>

            </div>
            <div id="sec2">
                <!-- History -->
                <div id="line4"><b>History:</b></div>
                <div id="line">
                    <div id="line1">Salon name</div>
                    <div id="line2">date and time</div>
                </div>


            </div>
        </div>
    </div>
    <script>
        //function to create new list from the data collected from the database
        function myFunction(i, h, m, n, id) {
            const node = document.getElementById("line");
            const clone = node.cloneNode(true);
            clone.style.display = "block";
            clone.innerHTML =
                '<div id="cont"><div id="line1">' + n + '</div><div id="line2">' + i + ' | ' + h + ':' + m +
                '</div><a href="bookings.php?delete=' + id + '" id="line3">cancel</a></div>';
            document.getElementById("sec1").appendChild(clone);
        }

        function myFunction2(i, h, m, n) {
            const node = document.getElementById("line");
            const clone = node.cloneNode(true);
            clone.style.display = "block";
            clone.innerHTML =
                '<div id="cont"><div id="line1">' + n + '</div><div id="line2">' + i + ' | ' + h + ':' + m +
                '</div></div>';
            document.getElementById("sec2").appendChild(clone);
        }
        //passing the php array to javascript
        var passedArray = <?php echo json_encode($b); ?>;
        var passedArray2 = <?php echo json_encode($c); ?>;
        var passedArray3 = <?php echo json_encode($gh); ?>;
        var passedArray4 = <?php echo json_encode($gm); ?>;
        var passedArray5 = <?php echo json_encode($lh); ?>;
        var passedArray6 = <?php echo json_encode($lm); ?>;
        var passedArray7 = <?php echo json_encode($gn); ?>;
        var passedArray8 = <?php echo json_encode($ln); ?>;
        var passedArray9 = <?php echo json_encode($idtg); ?>;
        var passedArray10 = <?php echo json_encode($idtl); ?>;


        //creating new elements according to the number in the database

        for (let i = 0; i < <?php echo $ee; ?>; i++) {
            myFunction(passedArray2[i], passedArray3[i], passedArray4[i], passedArray7[i], passedArray9[i]);
        }
        for (let i = 0; i < <?php echo $d; ?>; i++) {
            myFunction2(passedArray[i], passedArray5[i], passedArray6[i], passedArray8[i], passedArray10[i]);
        }
    </script>
</body>

</html>