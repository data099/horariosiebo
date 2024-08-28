<?php
include "conexion_be.php";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $perfil = $_POST['perfil'];
    $posgrado = $_POST['posgrado'];
    $categoria = $_POST['categoria'];
    $funcion = $_POST['funcion'];

    $sql = "INSERT INTO docentes (nombre_completo, perfil, posgrado, categoria, funcion)
    VALUES ('$nombre_completo', '$perfil', '$posgrado', '$categoria', '$funcion')";

    if ($conexion->query($sql) === TRUE) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    $conexion->close();
    header("Location: listaDocente.php"); // Redirige al usuario de nuevo a la página principal después de agregar el docente
    exit();
}
?>
