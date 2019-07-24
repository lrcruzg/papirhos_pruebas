<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Conexión fallida: ".$con->connect_error);
}
?>
