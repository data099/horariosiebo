<?php
session_start(); // Asegúrate de iniciar la sesión al principio
include 'conexion_be.php';

// Recuperar los datos del horario del asesor seleccionado
$horario = [];
if (isset($_SESSION['asesor'])) {
    $sql = "SELECT * FROM cargas_academicas WHERE asesor = ? ORDER BY id_carga";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $_SESSION['asesor']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $horario[] = $row;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga Académica Asesor</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/estilo_carga_asesor.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
</head>
<body>
    <div class="container">
        <nav class="sidebar">
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
        </nav> 

        <main class="main-content" id="content-to-export">
            <header>
                <img src="imagenes/iebo.png" alt="IEBO Logo" style="width: 50px;">
                <div class="header-text">
                    <h1>Instituto de Estudios de Bachillerato del Estado de Oaxaca</h1>
                    <h2>Dirección Académica</h2>
                    <h3>Departamento de Docencia e Investigación</h3>
                </div>
                <img src="imagenes/iebo.png" alt="IEBO Logo" style="width: 50px;">
            </header>

            <section class="table-container">
            <form method="POST" action="guardar_carga_academica.php">
                <table id="tabla-horario">
                    <thead>
                        <tr>
                            <th colspan="9" class="title">Carga Académica por Asesor</th>
                        </tr>
                        <tr>
                            <th>Plantel:</th>
                            <th><input type="text" id="plantel" name="plantel" value="<?php echo isset($_SESSION['plantel']) ? $_SESSION['plantel'] : ''; ?>" readonly></th>
                            <th>Región:</th>
                            <th><input type="text" id="region" name="region" value="<?php echo isset($_SESSION['region']) ? $_SESSION['region'] : ''; ?>"></th>                                
                        </tr>
                        <tr>
                            <th>Ciclo Semestral:</th>
                            <th><input type="text" id="ciclo-semestral" name="ciclo-semestral" value="<?php echo isset($_SESSION['ciclo-semestral']) ? $_SESSION['ciclo-semestral'] : ''; ?>"></th>
                            <th>Asesor(a):</th>
                            <th>
                            <select id="asesor" name="asesor" onchange="mostrarCargaAcademica(this.value)">
                                <?php
                                   $sql = "SELECT nombre_completo FROM docentes";
                                    $result = $conexion->query($sql);

                                 if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row["nombre_completo"]."'>".$row["nombre_completo"]."</option>";
                                       }
                                         } else {
                                            echo "<option value=''>No hay docentes registrados</option>";
                                        }
                                ?>
                            </select>

                            </th>
                        </tr>
                        <tr>
                            <th>Licenciatura/Ingeniería:</th>
                            <th><input type="text" id="perfil" name="perfil" value="<?php echo isset($_SESSION['perfil']) ? $_SESSION['perfil'] : ''; ?>" readonly></th>
                            <th>Posgrado (Maestría/Doctorado):</th>
                            <th><input type="text" id="posgrado" name="posgrado" value="<?php echo isset($_SESSION['posgrado']) ? $_SESSION['posgrado'] : ''; ?>" readonly></th>
                        </tr>
                        <tr>
                            <th>UAC/Servicio</th>
                            <th>Sem.</th>
                            <th>Gpo.</th>
                            <th>L</th>
                            <th>M</th>
                            <th>Mi</th>
                            <th>J</th>
                            <th>V</th>
                            <th>Horas semanales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de datos, ajustar según necesidades -->
                        <?php for ($i = 0; $i <11; $i++) { ?>
                        <tr>
                            <td>
                                <select name="uac[]">
                                    <?php
                                        $sql = "SELECT id, materias FROM materias";
                                        $result = $conexion->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='".$row["materias"]."' ".(isset($horario[$i]['uac']) && $horario[$i]['uac'] == $row["materias"] ? 'selected' : '').">".$row["materias"]."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay materias registradas</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="sem[]">
                                    <?php
                                        $sql = "SELECT DISTINCT semestre FROM materias";
                                        $result = $conexion->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='".$row["semestre"]."' ".(isset($horario[$i]['sem']) && $horario[$i]['sem'] == $row["semestre"] ? 'selected' : '').">".$row["semestre"]."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay semestres registrados</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="gpo[]">
                                    <?php
                                        $sql = "SELECT DISTINCT grupo FROM materias";
                                        $result = $conexion->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='".$row["grupo"]."' ".(isset($horario[$i]['gpo']) && $horario[$i]['gpo'] == $row["grupo"] ? 'selected' : '').">".$row["grupo"]."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay grupos registrados</option>";
                                        }
                                    ?>
                                </select>
                            </td>  
                            <td><input type="text" name="lunes[]" class="dia corto" value="<?php echo isset($horario[$i]['lunes']) ? $horario[$i]['lunes'] : ''; ?>" oninput="calcularTotales()"></td>
                            <td><input type="text" name="martes[]" class="dia corto" value="<?php echo isset($horario[$i]['martes']) ? $horario[$i]['martes'] : ''; ?>" oninput="calcularTotales()"></td>
                            <td><input type="text" name="miercoles[]" class="dia corto" value="<?php echo isset($horario[$i]['miercoles']) ? $horario[$i]['miercoles'] : ''; ?>" oninput="calcularTotales()"></td>
                            <td><input type="text" name="jueves[]" class="dia corto" value="<?php echo isset($horario[$i]['jueves']) ? $horario[$i]['jueves'] : ''; ?>" oninput="calcularTotales()"></td>
                            <td><input type="text" name="viernes[]" class="dia corto" value="<?php echo isset($horario[$i]['viernes']) ? $horario[$i]['viernes'] : ''; ?>" oninput="calcularTotales()"></td>
                            <td><input type="text" name="horas[]" class="horas" value="<?php echo isset($horario[$i]['horas_semanales']) ? $horario[$i]['horas_semanales'] : ''; ?>" readonly></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                            <td colspan="3">Totales</td>
                            <td><input type="text" id="total-lunes" class="corto" readonly></td>
                            <td><input type="text" id="total-martes" class="corto" readonly></td>
                            <td><input type="text" id="total-miercoles" class="corto" readonly></td>
                            <td><input type="text" id="total-jueves" class="corto" readonly></td>
                            <td><input type="text" id="total-viernes" class="corto" readonly></td>
                            <td><input type="text" id="total-horas" readonly></td>
                        </tr>
                    </tfoot>
                </table>
            </section>

            <div class="button-container">
                <button type="submit">Guardar</button>
                <button id="exportButton" type="button">Exportar a PDF</button>
            </div>
        </main>
    </div>
    <script src="js/carga_cademica.js"></script>
</body>
</html>
