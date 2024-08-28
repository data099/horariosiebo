<?php
session_start(); // Iniciar sesión

include 'conexion_be.php';  // Incluir el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plantel = $_POST['plantel'];
    $asesor = $_POST['asesor'];
    $ciclo_semestral = $_POST['ciclo-semestral'];
    $perfil = $_POST['perfil'];
    $posgrado = $_POST['posgrado'];
    $uac = $_POST['uac'];  
    $sem = $_POST['sem'];
    $gpo = $_POST['gpo'];
    $lunes = $_POST['lunes'];
    $martes = $_POST['martes'];
    $miercoles = $_POST['miercoles'];
    $jueves = $_POST['jueves'];
    $viernes = $_POST['viernes'];
    $horas_semanales = $_POST['horas'];

    // Inserción de los datos en la tabla `cargas_academicas`
    $sql = "INSERT INTO cargas_academicas (asesor, plantel, ciclo_semestral, perfil, posgrado, lunes, martes, miercoles, jueves, viernes, horas_semanales, sem, gpo, uac) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    for ($i = 0; $i < count($uac); $i++) {
        $stmt->bind_param(
            "ssssssssssssss",
            $asesor,
            $plantel,
            $ciclo_semestral,
            $perfil,
            $posgrado,
            $lunes[$i],
            $martes[$i],
            $miercoles[$i],
            $jueves[$i],
            $viernes[$i],
            $horas_semanales[$i],
            $sem[$i],
            $gpo[$i],
            $uac[$i]
        );

        if (!$stmt->execute()) {
            echo "Error al guardar: " . $stmt->error;
        }
    }

    echo "Registro guardado exitosamente";
    $stmt->close();
    $conexion->close();

    // Guardar los datos en la sesión para mantenerlos después de la redirección
    $_SESSION['plantel'] = $plantel;
    $_SESSION['asesor'] = $asesor;
    $_SESSION['ciclo-semestral'] = $ciclo_semestral;
    $_SESSION['perfil'] = $perfil;
    $_SESSION['posgrado'] = $posgrado;
    $_SESSION['uac'] = $uac;
    $_SESSION['sem'] = $sem;
    $_SESSION['gpo'] = $gpo;
    $_SESSION['lunes'] = $lunes;
    $_SESSION['martes'] = $martes;
    $_SESSION['miercoles'] = $miercoles;
    $_SESSION['jueves'] = $jueves;
    $_SESSION['viernes'] = $viernes;
    $_SESSION['horas'] = $horas_semanales;

    // Redirigir de nuevo al formulario después de guardar
    header("Location: carga_cademica_sesor.php");
    exit();
}
?>
