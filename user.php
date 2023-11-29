<?php
session_start();
include '../conecta.php';
//verifica si es user
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/css.css">
    <title>Página de Usuario</title>
</head>

<body class="cuerpo">
    <div class="mensaje">
        <?php echo $mensaje; ?>
    </div>
    <div class="container">
        <div class="container text-center">
        <h1>Bienvenido, Usuario</h1>
        </div>
        <ul>
            <li><a href="datossolousuarios/listado.php">Listas</a></li>
            <li><a href="datossolousuarios/formulario.php">formulario</a></li>

        </ul>
    </div>
    <a href="cerrar.php">Cerrar Sesión</a>
</body>

</html>
