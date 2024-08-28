<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/estilo_lista_docentes.css">
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
            <h2>Lista de Docentes</h2>
            <button id="agregar">Agregar</button>
            <table id="tabla-docentes">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Perfil</th>
                        <th>Posgrado</th>
                        <th>Categoría</th>
                        <th>Función</th>
                        <th>Acciones</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    include 'conexion_be.php';
                    $sql = "SELECT * FROM docentes";
                    $result = $conexion->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>".$row["nombre_completo"]."</td>
                                <td>".$row["perfil"]."</td>
                                <td>".$row["posgrado"]."</td>
                                <td>".$row["categoria"]."</td>
                                <td>".$row["funcion"]."</td>
                                <td><button class='editar'>Editar</button></td>
                            </tr>";
                    }   
                } else {
                    echo "<tr><td colspan='6'>No hay docentes registrados</td></tr>";
                }
                ?>
            </tbody>

            </table>

            <form id="form-docente" action="agregar_docente.php" method="POST" style="display: none;">
                <input type="hidden" id="docente_id" name="docente_id">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required><br>
                <label for="perfil">Perfil:</label>
                <input type="text" id="perfil" name="perfil"><br>
                <label for="posgrado">Posgrado:</label>
                <input type="text" id="posgrado" name="posgrado"><br>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria"><br>
                <label for="funcion">Función:</label>
                <input type="text" id="funcion" name="funcion"><br>
                <button type="submit">Guardar</button>
            </form>

            <div class="buttons">
                <button id="guardar" style="display: none;">Guardar</button>
            </div>
        </div>
    </div>
    <script src="js/listaDocente.js"></script>
</body>
</html>
