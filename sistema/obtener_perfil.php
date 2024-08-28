<?php
session_start();

include 'conexion_be.php';

if (isset($_GET['nombre_completo'])) {
    $nombre_completo = $_GET['nombre_completo'];

    $sql = "SELECT perfil, posgrado, categoria, funcion FROM docentes WHERE nombre_completo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre_completo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['perfil' => '', 'posgrado' => '', 'categoria' => '', 'funcion' => '']);
    }

    $stmt->close();
} else {
    echo json_encode(['perfil' => '', 'posgrado' => '', 'categoria' => '', 'funcion' => '']);
}

$conexion->close();
?>
