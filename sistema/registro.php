<?php
include 'conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    $query = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES ('$nombre_completo', '$correo', '$contrasena_encriptada')";
    if (mysqli_query($conexion, $query)) {
        echo '<script>alert("Registro exitoso."); window.location="login.php";</script>';
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - IEBO</title>
    <link rel="stylesheet" href="css/estilo_registro.css">
</head>
<body>

    <div class="logo">
        <img src="imagenes/iebo.png" alt="IEBO Logo">
    </div>

    <div class="container">
        <form action="registros_usuario.php" method="POST">
            <h2>Registrarse</h2>            
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre_completo" name="nombre_completo" required>
            
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required>
            
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>
            
            <button type="submit">Confirmar</button>
        </form>
    </div>
</body>
</html>
