<?php
include "conexion_be.php";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_docente'];
    $nombre_completo = $_POST['nombre_completo'];
    $perfil = $_POST['perfil'];
    $posgrado = $_POST['posgrado'];
    $categoria = $_POST['categoria'];
    $funcion = $_POST['funcion'];

    $sql = "UPDATE docentes SET nombre_completo='$nombre_completo', perfil='$perfil', posgrado='$posgrado', categoria='$categoria', funcion='$funcion' WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $conexion->close();
    header("Location: listaDocente.php"); // Redirige al usuario de nuevo a la página principal después de editar el docente
    exit();
}
?>
