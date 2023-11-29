<?php
session_start();
include '../../conecta.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/css.css">
    <title>Listados</title>
</head>

<body>
    <center>
        <h2>Listados</h2>
            <li><a href="listado/usuarios.php">usuarios</a></li>
            <li><a href="listado/entradas.php">entradas</a></li>
            <li><a href="listado/categorias.php">categorias</a></li>
    </center>
</body>

</html>
