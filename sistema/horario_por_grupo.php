<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario por Grupo</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/horario_grupo.css">
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
            <header id="header-content">
                <h1>Instituto de Estudios de Bachillerato del Estado de Oaxaca</h1>
                <h2>Dirección Académica</h2>
                <h3>Departamento de Docencia e Investigación</h3>
                <h4>Horario de Clase Ciclo Semestral 2024-A</h4>
            </header>

            <section class="header-info">
                <div>
                    <label for="plantel">Plantel: </label>
                    <input type="text" id="plantel" name="plantel">
                </div>
                
                <div>
                    <label for="region">Región: </label>
                    <input type="text" id="region" name="region">
                </div>
                <div>
                    <label for="grupo">Grupo: </label>
                    <select id="grupo" name="grupo" onchange="mostrarHorarioPorGrupo(this.value)">
                        <option value="">Seleccione un grupo</option>
                        <?php
                            include 'conexion_be.php'; // Conexión a la base de datos

                            $query = "SELECT DISTINCT gpo FROM cargas_academicas";
                            $result = $conexion->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['gpo'] . '">' . $row['gpo'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay grupos disponibles</option>';
                            }

                            $conexion->close();
                        ?>
                    </select>
                </div>
            </section>

            <section class="table-container">
                <table id="tabla-horario">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include 'grupo_datos.php'; // Incluye el archivo con la función PHP para mostrar el horario

                        // Obtener la hora de inicio de clases desde una variable de sesión
                        session_start();
                        $horaInicioClases = isset($_SESSION['hora_inicio_clases']) ? $_SESSION['hora_inicio_clases'] : '08:00';
                        $horarios = generarHorarios($horaInicioClases);

                        // Generar la tabla vacía
                        foreach ($horarios as $index => $hora) {
                            echo "<tr>";
                            echo "<td class='hora'>$hora</td>";

                            $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
                            foreach ($dias as $dia) {
                                echo "<td class='dia' id='${dia}_$index'></td>";
                            }

                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="js/horarioporgrupo.js"></script>
</body>
</html>
