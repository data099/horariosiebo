<?php
include 'conexion_be.php';

$nombre_completo = $_POST['nombre_completo'];

// Verifica si la variable $nombre_completo está definida
if (isset($nombre_completo) && !empty($nombre_completo)) {
    // Asegúrate de usar el nombre de la columna correcto: "asesor"
    $sql = "SELECT sem, gpo, lunes, martes, miercoles, jueves, viernes, uac, horas FROM cargas_academicas WHERE asesor = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $nombre_completo);
    $stmt->execute();
    $result = $stmt->get_result();

    $horario = [];
    while ($row = $result->fetch_assoc()) {
        $horario[] = $row;
    }

    echo json_encode($horario);

    $stmt->close();
} else {
    echo json_encode([]);
}

$conexion->close();
?>
