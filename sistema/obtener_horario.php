<?php
include 'conexion_be.php';

if (isset($_GET['asesor'])) {
    $asesor = $_GET['asesor'];

    $sql = "SELECT uac, sem, gpo, lunes, martes, miercoles, jueves, viernes, horas_semanales 
            FROM cargas_academicas WHERE asesor = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $asesor);
    $stmt->execute();
    $result = $stmt->get_result();

    $horario = [];
    while ($row = $result->fetch_assoc()) {
        $horario[] = $row;
    }

    echo json_encode($horario);

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode([]);
}
?>