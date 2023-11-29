<?php
session_start();
include '../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Consulta para obtener la lista de usuarios
    $sqlUsuarios = "SELECT * FROM Usuarios";
    $resultadoUsuarios = $conexion->query($sqlUsuarios);
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../../css/css.css">
        <title>Listado dinamica</title>
    </head>

    <body>
        <h1>Listado de Usuarios</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Operaciones</th>
            </tr>
            <?php
            while ($filaUsuarios = $resultadoUsuarios->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $filaUsuarios['id'] . "</td>";
                echo "<td>" . $filaUsuarios['nombre'] . "</td>";
                echo "<td>" . $filaUsuarios['apellido'] . "</td>";
                echo "<td>" . $filaUsuarios['email'] . "</td>";
                echo "<td>" . $filaUsuarios['perfil'] . "</td>";
                echo "<td><a href='detalle_dinamica.php?id=" . $filaUsuarios['id'] . "'>Ver Detalle</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </body>

    </html>

    <?php
} else {
    echo "Método no permitido";
}

// Cierra la conexión a la base de datos
$conexion = null;
?>