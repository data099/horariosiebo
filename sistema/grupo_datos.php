<?php
include 'conexion_be.php';

function mostrarHorarioPorGrupo($grupo) {
    global $conexion;

    $query = "SELECT uac, lunes, martes, miercoles, jueves, viernes FROM cargas_academicas WHERE gpo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $grupo);
    $stmt->execute();
    $result = $stmt->get_result();

    $horario = [];
    while ($row = $result->fetch_assoc()) {
        // Organiza el horario por día
        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
            if (!isset($horario[$dia])) {
                $horario[$dia] = [];
            }
            $horario[$dia][] = $row[$dia] ? $row['uac'] : ''; // Coloca el nombre de la materia en la celda correspondiente
        }
    }

    $stmt->close();
    $conexion->close();

    return $horario;
}

function generarHorarios($horaInicio) {
    $horarios = [];
    $horaActual = new DateTime($horaInicio);

    for ($i = 0; $i < 8; $i++) {
        $horarios[] = $horaActual->format('H:i');
        $horaActual->modify('+60 minutes');
    }

    return $horarios;
}
?>
