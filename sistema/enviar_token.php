<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

include('conexion_be.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];

    // Verificar si el correo existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50)); // Generar un token único
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token expira en 1 hora

        // Guardar el token y la expiración en la base de datos
        $query = "UPDATE usuarios SET token = '$token', token_expire = '$expires_at' WHERE correo = '$correo'";
        mysqli_query($conexion, $query);

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuraciones del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.tudominio.com'; // Configura tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'tu_correo@tudominio.com'; // Tu correo SMTP
            $mail->Password = 'tu_contraseña'; // Tu contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuraciones del correo
            $mail->setFrom('tu_correo@tudominio.com', 'Tu Nombre');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Solicitud de Restablecimiento de Contraseña';
            $reset_link = "https://tudominio.com/restablecer_contraseña.php?token=" . $token;
            $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$reset_link'>$reset_link</a>";

            $mail->send();
            echo '<script>alert("Se ha enviado un enlace para restablecer tu contraseña a tu correo electrónico."); window.location="login.php";</script>';
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script>alert("Correo electrónico no encontrado."); window.location="recuperacontraseña.html";</script>';
    }
}
?>
