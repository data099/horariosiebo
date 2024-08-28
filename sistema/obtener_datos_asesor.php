<?php
include 'conexion_be.php';

if (isset($_POST['id_docente'])) {
    $id_docente = $_POST['id_docente'];

    $sql = "SELECT perfil, posgrado FROM docentes WHERE id_docente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_docente);
    $stmt->execute();
    $stmt->bind_result($perfil, $posgrado);
    $stmt->fetch();

    $response = array(
        'perfil' => $perfil,
        'posgrado' => $posgrado
    );

    echo json_encode($response);

    $stmt->close();
}
$conexion->close();
?>
