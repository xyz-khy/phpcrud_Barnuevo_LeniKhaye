<?php
$servername = "localhost";
$username   = "root";      
$password   = "";          
$dbname     = "phpcrud_Barnuevo_LeniKhaye";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>