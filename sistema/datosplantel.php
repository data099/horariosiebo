<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Plantel</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/estilo_datos_plantel.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="inicio.php" class="active">Inicio</a></li>
                <li><a href="perfil.php" class="active">Perfil</a></li>
                <li><a href="datosplantel.php" class="active">Datos del Plantel</a></li>
                <li><a href="listaDocente.php" class="active">Lista de Docentes</a></li>
                <li><a href="carga_cademica_sesor.php" class="active">Carga Académica por Asesor</a></li>
                <li><a href="horarioporDocente.php" class="active">Horario por Docente</a></li>
                <li><a href="horario_por_grupo.php" class="active">Horario por grupo</a></li>
                <li><a href="oficio.php" class="active">Primer Oficio</a></li>
                <li><a href="oficio_dos.php" class="active">Segundo Oficio</a></li>
                <li><a href="cerrar_sesion.php" class="active">Cerrar Sesión</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <h2>Datos del Plantel</h2>
            <div class="form-container">
                <form id="datos-plantel-form" method="POST" action="datosplantel.php">
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

                    // Inicializar variables
                    $fecha_carga = $fecha_rta = $dia_rta = $periodo = $tipo_periodo = $region = $semestre_1 = $semestre_2 = $semestre_3 = $hora_inicio_clases = $titular = "";
                    $plantel_id = 0;

                    // Cargar datos desde la base de datos si existen
                    if (isset($_SESSION['plantel_id'])) {
                        $plantel_id = $_SESSION['plantel_id'];
                        $sql = "SELECT * FROM registros_plantel WHERE plantel_id = $plantel_id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $fecha_carga = $row['fecha_carga'];
                            $fecha_rta = $row['fecha_rta'];
                            $dia_rta = $row['dia_rta'];
                            $periodo = $row['periodo'];
                            $tipo_periodo = $row['tipo_periodo'];
                            $region = $row['region'];
                            $semestre_1 = $row['semestre_1'];
                            $semestre_2 = $row['semestre_2'];
                            $semestre_3 = $row['semestre_3'];
                            $hora_inicio_clases = $row['hora_inicio_clases'];
                            $titular = $row['titular'];
                        }
                    }

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
                        echo '<script>
                                localStorage.setItem("plantel_nombre", "'.$plantel_id.'");
                                localStorage.setItem("region", "'.$region.'");
                                localStorage.setItem("tipo_periodo", "'.$tipo_periodo.'");
                                localStorage.setItem("titular", "'.$titular.'");
                                localStorage.setItem("hora_inicio_clases", "'.$hora_inicio_clases.'");
                                window.location.href = "datosplantel.php";
                              </script>';
                        exit();
                    }
                    ?>

                    <div>
                        <label for="fecha-carga">Fecha de elaboración de Cargas académicas y horarios de clase</label>
                        <input type="date" id="fecha-carga" name="fecha-carga" value="<?php echo $fecha_carga; ?>" required>
                    </div>
                    <div>
                        <label for="fecha-rta">Reunión de Aceptación de carga (RTA)</label>
                        <input type="date" id="fecha-rta" name="fecha-rta" value="<?php echo $fecha_rta; ?>" required>
                    </div>
                    <div>
                        <label for="dia-rta">Día para la RTA</label>
                        <input type="text" id="dia-rta" name="dia-rta" value="<?php echo $dia_rta; ?>" required>
                    </div>
                    <div>
                        <label for="periodo">Periodo</label>
                        <input type="text" id="periodo" name="periodo" value="<?php echo $periodo; ?>" required>
                    </div>
                    <div>
                        <label for="tipo-periodo">Tipo Periodo</label>
                        <input type="text" id="tipo-periodo" name="tipo-periodo" value="<?php echo $tipo_periodo; ?>" required>
                    </div>
                    <div>
                        <label for="plantel">Plantel</label>
                        <select id="plantel" name="plantel" required>
                            <?php
                            $sql = "SELECT id, nombre FROM planteles";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = ($plantel_id == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No hay planteles disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="region">Región</label>
                        <input type="text" id="region" name="region" value="<?php echo $region; ?>" required>
                    </div>
                    <div>
                        <label for="semestre-1">Semestre 1</label>
                        <input type="text" id="semestre-1" name="semestre-1" value="<?php echo $semestre_1; ?>" required>
                    </div>
                    <div>
                        <label for="semestre-2">Semestre 2</label>
                        <input type="text" id="semestre-2" name="semestre-2" value="<?php echo $semestre_2; ?>" required>
                    </div>
                    <div>
                        <label for="semestre-3">Semestre 3</label>
                        <input type="text" id="semestre-3" name="semestre-3" value="<?php echo $semestre_3; ?>" required>
                    </div>
                    <div>
                        <label for="hora">Hora de inicio de clases</label>
                        <input type="text" id="hora" name="hora" value="<?php echo $hora_inicio_clases; ?>" required>
                    </div>
                    <div>
                        <label for="titular">Titular del Departamento de Docencia e Investigación</label>
                        <input type="text" id="titular" name="titular" value="<?php echo $titular; ?>" required>
                    </div>
                    <div class="buttons">
                        <button type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/datosplantel.js"></script>
</body>
</html>
