<?php
include('conexion_be.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $token = $_GET['token'];

    // Verificar si el token es válido y no ha expirado
    $query = "SELECT * FROM usuarios WHERE token = '$token' AND token_expire > NOW()";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restablecer Contraseña</title>
            <link rel="stylesheet" href="css/estilologin.css">
        </head>
        <body>
        
        <div class="contenedor-imagen">
            <img src="imagenes/iebo.png" alt="IEBO">
        </div>
        
        <div class="formulario">
            <h1>Restablecer Contraseña</h1>

            <form method="post" action="restablecer_contraseña.php">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <div class="username">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="contrasena" required>                
                </div>

                <input type="submit" value="Restablecer Contraseña">
            </form>
        </div>

        </body>
        </html>
        <?php
    } else {
        echo '<script>alert("Token inválido o expirado."); window.location="login.php";</script>';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $nueva_contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    // Verificar el token
    $query = "SELECT correo FROM usuarios WHERE token = '$token' AND token_expire > NOW()";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $correo = $row['correo'];

        // Actualizar la contraseña en la base de datos
        $query = "UPDATE usuarios SET contrasena = '$nueva_contrasena', token = NULL, token_expire = NULL WHERE correo = '$correo'";
        mysqli_query($conexion, $query);

        echo '<script>alert("Tu contraseña ha sido restablecida exitosamente."); window.location="login.php";</script>';
    } else {
        echo '<script>alert("Token inválido o expirado."); window.location="login.php";</script>';
    }
}
?>
