<?php
session_start();
include '../conecta.php';
//verifica si es admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/css.css">
    <title>Página de Administrador</title>
</head>
<body class="cuerpo">
    <div class="mensaje">
        <?php echo $mensaje; ?>
    </div>
    <div class="container">
        <div class="container text-center">
        <h1>Bienvenido, Administrador</h1>
        </div>
        <ul>
            <li><a href="datos/listado.php">Listas</a></li>
            <li><a href="datos/formulario.php">formulario</a></li>
            <li><a href="datos/dinamica/dinamica.php">página dinámica</a></li>
            <li><a href="datos/paginacion/paginacion.php">páginacion</a></li>
            <li><a href="datos/CKEditor/CKEditor.php">CKEditor</a></li>
            <li><a href="datos/pdf/pdf.php">pdf</a></li>
            <li><a href="datos/fechas/fechas.php">ordenar por fechas</a></li>
            <li><a href="datos/log/log.php">logs</a></li>
            <li><a href="datos/log/gestionlog.php">gestión logs</a></li>
        </ul>
    </div>
    <a href="cerrar.php">Cerrar Sesión</a>
</body>

</html>
