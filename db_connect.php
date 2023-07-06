<?php
// Connect to the database
$server = "localhost";
$username = "root";
$password = "shruthi";
$dbname = "CLASSCONNECT";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    echo "Failed due to: " . mysqli_connect_error();
}

?>