<?php
include 'conexion_be.php';

if (isset($_GET['grupo'])) {
    $grupo = $_GET['grupo'];

    $sql = "SELECT uac, lunes, martes, miercoles, jueves, viernes
            FROM cargas_academicas 
            WHERE gpo = ? 
            ORDER BY id_carga";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $grupo);
    $stmt->execute();
    $result = $stmt->get_result();

    $horario = [];
    while ($row = $result->fetch_assoc()) {
        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
            if (!isset($horario[$dia])) {
                $horario[$dia] = [];
            }
            $horario[$dia][] = $row[$dia] ? $row['uac'] : ''; // Coloca el nombre de la materia en lugar del símbolo
        }
    }

    echo json_encode($horario);

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode([]);
}
?>
