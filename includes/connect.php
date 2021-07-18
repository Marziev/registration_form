<?php

$servername = "localhost";
$username = "marziev_reg";
$password = "VOS500tss";
$dbname = "marziev_reg";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>