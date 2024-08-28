<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/estilo_horario_docente.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
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
                <img src="imagenes/iebo.png" alt="IEBO Logo" class="header-logo">
                <div class="header-text">
                    <h1>Instituto de Estudios de Bachillerato del Estado de Oaxaca</h1>
                    <h2>Dirección Académica</h2>
                    <h3>Departamento de Docencia e Investigación</h3>
                </div>
                <img src="imagenes/iebo.png" alt="IEBO Logo" class="header-logo">
            </header>

            <section class="info-container">
                <div class="info-box">
                    <div class="info-item large">
                        <label for="plantel">Plantel:</label>
                        <input type="text" id="plantel" name="plantel" readonly>
                    </div>
                    <div class="info-item">
                        <label for="region">Región:</label>
                        <input type="text" id="region" name="region">
                    </div>
                    <div class="info-item large">
                        <label for="nombre-director">Nombre del Director:</label>
                        <input type="text" id="nombre-director" name="nombre-director">
                    </div>
                    <div class="info-item large">
                        <label for="asesor">Docente:</label>
                        <select id="asesor" name="asesor" onchange="mostrarPerfil(this.value)">
                            <option value="">Seleccionar Docente</option>
                            <?php
                                include 'conexion_be.php';
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
                    </div>
                    <div class="info-item">
                        <label for="categoria">Categoria:</label>
                        <input type="text" id="categoria" name="categoria" readonly>
                    </div>
                    <div class="info-item">
                        <label for="funcion">Función:</label>
                        <input type="text" id="funcion" name="funcion" readonly>
                    </div>
                </div>
            </section>

            <section class="table-container">
                <table id="tabla-horario">
                    <thead>
                        <tr>
                            <th class="hora">Hora</th>
                            <th class="dia">Lunes</th>
                            <th class="grupo">Grupo Escolar</th>
                            <th class="dia">Martes</th>
                            <th class="grupo">Grupo Escolar</th>
                            <th class="dia">Miércoles</th>
                            <th class="grupo">Grupo Escolar</th>
                            <th class="dia">Jueves</th>
                            <th class="grupo">Grupo Escolar</th>
                            <th class="dia">Viernes</th>
                            <th class="grupo">Grupo Escolar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se generarán dinámicamente -->
                    </tbody>
                </table>
            </section>

            <div class="button-container">
                <button id="export-pdf">Exportar PDF</button>
            </div>
        </main>
    </div>
    <script src="js/horarioporDocente.js"></script>
</body>
</html>
