<?php
session_start();
include "conexion_be.php";

$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];

// Verifica las credenciales del usuario
$query = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
$result = mysqli_query($conexion, $query);

if(mysqli_num_rows($result) == 1){
    $_SESSION['usuario'] = $correo;
    header("Location: inicio.php");
} else {
    echo '
    <script>
        alert("Correo o contraseña incorrectos");
        window.location = "login.php";
    </script>';
}

mysqli_close($conexion);
?>
