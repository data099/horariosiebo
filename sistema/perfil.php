<?php
// perfil.php
session_start();
include 'conexion_be.php';

// Verificar si la sesión está iniciada y si el ID del usuario está definido
if (!isset($_SESSION['usuarios'])) {
    echo "Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['usuarios'];

// Recuperar los datos del usuario
$query = "SELECT nombre_completo, correo FROM usuarios WHERE id='$id_usuario'";
$result = mysqli_query($conexion, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nombre_completo = $row['nombre_completo'];
    $correo = $row['correo'];
} else {
    echo "Error recuperando los datos del usuario.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/estilo_menu.css">
    <link rel="stylesheet" href="css/estilo_perfil.css">
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
            <div class="profile-picture">
                <img id="profile-img" src="path/to/default-profile-picture.png" alt="Foto de perfil">
                <input type="file" id="profile-picture-input" accept="image/*">
            </div>

            <div class="form-container">
                <form id="profile-form" method="POST" action="actualizar_perfil.php">
                    <div>
                        <label for="nombre_completo">Nombre</label>
                        <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($nombre_completo); ?>" disabled>
                    </div>
                    <div>
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" disabled>
                    </div>
                    <div>
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar" disabled>
                    </div>
                    <div class="buttons">
                        <button type="button" id="edit-button">Editar</button>
                        <button type="submit" id="save-button" disabled>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('edit-button').addEventListener('click', function() {
            document.getElementById('nombre_completo').disabled = false;
            document.getElementById('correo').disabled = false;
            document.getElementById('contrasena').disabled = false;
            document.getElementById('save-button').disabled = false;
        });
    </script>
</body>
</html>
