<?php
session_start();
include '../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Comprobar si se proporciona un ID de usuario en la URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtener el ID del usuario desde la URL
        $idUsuario = $_GET['id'];

        // Consulta para obtener los detalles del usuario
        $sqlDetalleUsuario = "SELECT * FROM Usuarios WHERE id = $idUsuario";
        $resultadoDetalleUsuario = $conexion->query($sqlDetalleUsuario);

        if ($resultadoDetalleUsuario->rowCount() > 0) {
            $detalleUsuario = $resultadoDetalleUsuario->fetch(PDO::FETCH_ASSOC);
            ?>

            <!DOCTYPE html>
            <html lang="es">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="../../../css/css.css">
                <title>Detalle de Usuario</title>
            </head>

            <body>
                <h1>Detalle de Usuario</h1>
                <ul>
                    <li><strong>ID:</strong>
                        <?php echo $detalleUsuario['id']; ?>
                    </li>
                    <li><strong>Nombre:</strong>
                        <?php echo $detalleUsuario['nombre']; ?>
                    </li>
                    <li><strong>Apellido:</strong>
                        <?php echo $detalleUsuario['apellido']; ?>
                    </li>
                    <li><strong>Email:</strong>
                        <?php echo $detalleUsuario['email']; ?>
                    </li>
                    <li><strong>Perfil:</strong>
                        <?php echo $detalleUsuario['perfil']; ?>
                    </li>
                </ul>

                <h2>Entradas del Usuario</h2>
                <?php
                // Consulta para obtener las entradas del usuario
                $sqlEntradasUsuario = "SELECT * FROM Entradas WHERE id_usuario = $idUsuario";
                $resultadoEntradasUsuario = $conexion->query($sqlEntradasUsuario);

                if ($resultadoEntradasUsuario->rowCount() > 0) {
                    ?>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>Fecha de Creación</th>
                        </tr>
                        <?php
                        while ($filaEntrada = $resultadoEntradasUsuario->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $filaEntrada['id'] . "</td>";
                            echo "<td>" . $filaEntrada['titulo'] . "</td>";
                            echo "<td>" . $filaEntrada['contenido'] . "</td>";
                            echo "<td>" . $filaEntrada['fecha_creacion'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    echo "El usuario no tiene entradas.";
                }
                ?>

                <a href="dinamica.php">Volver al listado</a>
            </body>

            </html>

            <?php
        } else {
            echo "Usuario no encontrado";
        }
    } else {
        echo "ID de usuario no proporcionado o no válido.";
    }
} else {
    echo "Método no permitido";
}

// Cierra la conexión a la base de datos
$conexion = null;
?>