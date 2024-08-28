<?php
session_start(); // Iniciar sesión para usar variables de sesión

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_registro";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar solicitudes GET para obtener la región del plantel
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['plantel_id'])) {
    $plantel_id = $_GET['plantel_id'];

    $sql_plantel = $conn->prepare("SELECT region FROM planteles WHERE id = ?");
    $sql_plantel->bind_param("i", $plantel_id);
    $sql_plantel->execute();
    $result_plantel = $sql_plantel->get_result();

    if ($result_plantel->num_rows > 0) {
        $row_plantel = $result_plantel->fetch_assoc();
        echo json_encode($row_plantel);
    } else {
        echo json_encode(['region' => '']);
    }

    $conn->close();
    exit();
}

// Manejar solicitudes POST para guardar datos del plantel
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plantel_id = $_POST['plantel'];
    $fecha_carga = $_POST['fecha-carga'];
    $fecha_rta = $_POST['fecha-rta'];
    $dia_rta = $_POST['dia-rta'];
    $periodo = $_POST['periodo'];
    $tipo_periodo = $_POST['tipo-periodo'];
    $region = $_POST['region'];
    $semestre_1 = $_POST['semestre-1'];
    $semestre_2 = $_POST['semestre-2'];
    $semestre_3 = $_POST['semestre-3'];
    $hora_inicio_clases = $_POST['hora'];
    $titular = $_POST['titular'];

    // Guardar los datos en la sesión
    $_SESSION['plantel_id'] = $plantel_id;
    $_SESSION['fecha_carga'] = $fecha_carga;
    $_SESSION['fecha_rta'] = $fecha_rta;
    $_SESSION['dia_rta'] = $dia_rta;
    $_SESSION['periodo'] = $periodo;
    $_SESSION['tipo_periodo'] = $tipo_periodo;
    $_SESSION['region'] = $region;
    $_SESSION['semestre_1'] = $semestre_1;
    $_SESSION['semestre_2'] = $semestre_2;
    $_SESSION['semestre_3'] = $semestre_3;
    $_SESSION['hora_inicio_clases'] = $hora_inicio_clases;
    $_SESSION['titular'] = $titular;

    // Obtener el nombre del plantel para guardarlo en la sesión
    $sql_plantel_nombre = $conn->prepare("SELECT nombre FROM planteles WHERE id = ?");
    $sql_plantel_nombre->bind_param("i", $plantel_id);
    $sql_plantel_nombre->execute();
    $result_plantel_nombre = $sql_plantel_nombre->get_result();

    if ($result_plantel_nombre->num_rows > 0) {
        $row_plantel_nombre = $result_plantel_nombre->fetch_assoc();
        $_SESSION['plantel_nombre'] = $row_plantel_nombre['nombre'];
    }

    // Insertar o actualizar los datos en la base de datos
    $sql = $conn->prepare("INSERT INTO registros_plantel (plantel_id, fecha_carga, fecha_rta, dia_rta, periodo, tipo_periodo, region, semestre_1, semestre_2, semestre_3, hora_inicio_clases, titular)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                           ON DUPLICATE KEY UPDATE
                           fecha_carga = VALUES(fecha_carga), fecha_rta = VALUES(fecha_rta), dia_rta = VALUES(dia_rta), periodo = VALUES(periodo), tipo_periodo = VALUES(tipo_periodo), region = VALUES(region), semestre_1 = VALUES(semestre_1), semestre_2 = VALUES(semestre_2), semestre_3 = VALUES(semestre_3), hora_inicio_clases = VALUES(hora_inicio_clases), titular = VALUES(titular)");

    $sql->bind_param("isssssssssss", $plantel_id, $fecha_carga, $fecha_rta, $dia_rta, $periodo, $tipo_periodo, $region, $semestre_1, $semestre_2, $semestre_3, $hora_inicio_clases, $titular);

    if ($sql->execute()) {
        echo "Datos guardados correctamente";
    } else {
        echo "Error: " . $sql->error;
    }

    $conn->close();
    header("Location: datosplantel.php");
    exit();
}
?>
