<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficio Personal de Apoyo</title>
    <link rel="stylesheet" href="css/estilo_ofidos.css">
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

    <!-- Segundo Oficio -->
    <div class="main-content-ofi">
    <h2 class="section-title">Oficio Personal de Apoyo</h2>
    <form id="oficioFormdos" action="descargar_oficio.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="oficio_type" value="segundo">
        <div class="form-group">
            <label for="lugar_dos">Lugar:</label>
            <input type="text" id="lugar_dos" name="lugar">
        </div>
        <div class="form-group">
            <label for="fecha_dos">Fecha:</label>
            <input type="text" id="fecha_dos" name="fecha">
        </div>
        <div class="form-group">
            <label for="dirigidoA_dos">Dirigido a:</label>
            <input type="text" id="dirigidoA_dos" name="dirigidoA">
        </div>
        <div class="form-group">
            <label for="cargo_dos">Cargo:</label>
            <input type="text" id="cargo_dos" name="cargo">
        </div>
        <div class="form-group">
            <label for="contenido_dos">Contenido:</label>
            <textarea id="contenido_dos" name="contenido" rows="10">
            Por medio del presente, le informo que el (la) C._____________________, es personal de apoyo patrocinado  por _________________________, el cual atenderá algunas de las Unidades de Aprendizaje Curricular (UAC) del Mapa Curricular vigente durante el semestre "___ ", con la finalidad de equilibrar la Carga Académica del personal adscrito al Plantel, y contribuir en la formación integral de los estudiantes. Cabe mencionar que para la distribución se ha considerado los lineamientos que emanan de la Circular IEBO/DAc/"___"/2024.
            </textarea>
        </div>
        <table class="signature-table" id="signatureTableDos">
            <thead>
            <h3>Atentamente</h3>
                <tr>
                    <th></th>
                    <th>Nombre del responsable de la UAC</th>
                    <th>UAC</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Director</td>
                    <td><input type="text" name="director_dos"></td>
                    <td><input type="text" name="firma_director_dos" placeholder="Firma"></td>
                </tr>
            </tbody>
        </table>       
                    
        <button type="button" id="addRowBtnDos">Agregar Fila</button>
        <button type="submit" formaction="descargar_oficio_apoyo.php">Descargar como .docx</button>
    </form>
</div>
</div>

<script src="js/oficio_dos.js"></script>
</body>
</html>




