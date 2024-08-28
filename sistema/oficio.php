<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficios</title>
    <link rel="stylesheet" href="css/estilo_ofi.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
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

         <!-- Primer Oficio -->
    <div class="main-content-of">
        <h2 class="section-title">Oficio Aceptación de la Carga Académica Total</h2>
        <form id="oficioForm" action="descargar_oficio.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="oficio_type" value="primero">
            <div class="form-group">
                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar">
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="text" id="fecha" name="fecha">
            </div>
            <div class="form-group">
                <label for="dirigidoA">Dirigido a:</label>
                <input type="text" id="dirigidoA" name="dirigidoA">
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo">
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="10">
Con la finalidad de dar cumplimiento al artículo 71 fracción VII y VIII, del Reglamento de Trabajo de Personal, comunico a usted que en Reunión Técnico Académica (RTA) llevada a cabo el día ", G5, " de ", I5, " del año ", J5, " con la asistencia de los Asesores Académicos del plantel ", 'Configuración'!B7, " se distribuyó de manera conjunta la carga académica para el ciclo semestral ", 'Configuración'!B5, ". En ese mismo sentido, se estableció en colegiado, desarrollar la RTA el día ", 'Configuración'!B4, " de cada semana, con el propósito de dar seguimiento a los procesos académicos y administrativos en beneficio de los estudiantes del plantel.
                </textarea>
            </div>
            <table class="signature-table" id="signatureTable">
                <thead>
                    <h3>Atentamente</h3>
                    <tr>
                        <th>Puesto</th>
                        <th>Nombre</th>
                        <th>Firma</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Director</td>
                        <td><input type="text" name="director"></td>
                        <td><input type="text" name="firma_director" placeholder="Firma"></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="addRowBtn">Agregar Fila</button>
            <button type="submit" formaction="descargar_oficio.php">Descargar como .docx</button>
        </form>
    </div>
</div>
<script src="js/oficios.js"></script>
</body>
</html>
