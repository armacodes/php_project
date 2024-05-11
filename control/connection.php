<?php
// CONEXION LOCAL BD
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "project_php";

$conn = mysqli_connect($servername, $username, $password, $dbname);

/*if (mysqli_connect_errno()) {
    echo "Falló la conexión: " . mysqli_connect_error();
} else {
    echo "Conexión exitosa!";
}*/

$conn->set_charset("utf8");
?> 
