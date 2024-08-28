<?php
include 'conexion_be.php';
session_start();

// Verificar si la sesión está iniciada y si el ID del usuario está definido
if (!isset($_SESSION['usuarios'])) {
    echo "Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['usuarios'];

// Obtener los datos del formulario
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Validar y preparar la consulta SQL
$actualizar_datos = "UPDATE usuarios SET nombre_completo='$nombre_completo', correo='$correo'";

if (!empty($contrasena)) {
    $actualizar_datos .= ", contrasena='$contrasena'";
}

$actualizar_datos .= " WHERE id='$id_usuario'";

if (mysqli_query($conexion, $actualizar_datos)) {
    echo "Datos actualizados correctamente";
    header("Location: perfil.php");
} else {
    echo "Error actualizando los datos: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
