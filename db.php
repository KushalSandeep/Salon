<?php
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('Name', 'salondb');

//connecting database
try {
    $pdo = new PDO("mysql:host=" . SERVER . ";dbname=" . Name, USERNAME, PASSWORD);
} catch (PDOException $e) {
    die("ERROR: could not connect. " . $e->getMessage());
}