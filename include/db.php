<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lifehub";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: ");
}
?>
