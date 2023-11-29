<?php
session_start();

include 'conecta.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        $stmt = $conexion->prepare("SELECT id, perfil, password FROM usuarios WHERE nombre = :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($contrasena, $resultado['password'])) {
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['perfil_usuario'] = $resultado['perfil'];

            if ($_SESSION['perfil_usuario'] == 'admin') {
                header('Location: php/admin.php');
            } else {
                header('Location: php/user.php');
            }
            exit();
        } else {
            $mensaje_error = "Inicio de sesión fallido.";
        }
    }
} catch (PDOException $e) {
    $mensaje = "Error de conexión: " . $e->getMessage();
    echo $mensaje;
    die();
} finally {
    // Cierre de conexión
    $conexion = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/css2.css">
</head>

<body>
    <form method="POST" action="index.php">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <?php if (isset($mensaje_error)) : ?>
        <div><?php echo $mensaje_error; ?></div>
    <?php endif; ?>
</body>

</html>
