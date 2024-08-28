<?php
include "conexion_be.php";  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verifica si el correo ya existe
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

    if (mysqli_num_rows($verificar_correo) > 0) {
        echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location="registro.php";
        </script>';
        exit();
    }

    // Inserta el nuevo usuario
    $query = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES ('$nombre_completo', '$correo', '$contrasena')";
    $ejecutar = mysqli_query($conexion, $query);

    // Comprobación de errores
    if ($ejecutar) {
        echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location= "login.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Inténtalo de nuevo, usuario no almacenado: ' . mysqli_error($conexion) . '");
            window.location= "registro.php";
        </script>';
    }

    mysqli_close($conexion);
}
?>
