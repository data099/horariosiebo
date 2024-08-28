<?php
session_start();
include('conexion_be.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verifica si el correo y la contraseña coinciden con algún registro en la base de datos
    $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['usuarios'] = $row['id']; // Usar 'id' como nombre de la columna
        header("Location: inicio.php");
        exit();
    } else {
        echo '<script>alert("Correo o contraseña incorrectos."); window.location="login.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilo_login.css">
</head>
<body>
    
<div class="contenedor-imagen">
    <img src="imagenes/iebo.png" alt="IEBO">
</div>
    
<div class="formulario">
    <h1>Sistema de carga <br>académica</h1>

    <form method="post" action="login.php">
        <div class="username">
            <label>Correo Electronico</label>
            <input type="email" name="correo" required>                
        </div>
        <div class="username">
            <label>Contraseña</label> 
            <input type="password" name="contrasena" required>                         
        </div>

        <input type="submit" value="Iniciar Sesión">

        <div class="registrarse">
            <a href="registro.php">Registrarse</a>
        </div>
        
        <div class="recordar">
            <a href="recuperacontraseña.html">¿Olvidó su contraseña?</a>
        </div>        
    </form>
</div>

</body>
</html>
