<?php

$conexion = mysqli_connect("localhost", "root", "", "login_registro");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>

