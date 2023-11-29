<?php
session_start();
include '../../../conecta.php';

// Función para obtener la conexión a la base de datos
function obtenerConexion() {
    global $host, $usuario, $contrasena, $base_datos;
    try {
        $conexion = new PDO("mysql:host=$host;dbname=$base_datos", $usuario, $contrasena);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("SET NAMES utf8");
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}


// Función para obtener el total de entradas
function obtenerTotalEntradas() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM Entradas");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    return $total;
}

// Función para obtener las entradas paginadas
function obtenerEntradasPaginadas($pagina, $porPagina) {
    $conexion = obtenerConexion();
    $inicio = ($pagina - 1) * $porPagina;
    $stmt = $conexion->prepare("SELECT * FROM Entradas ORDER BY fecha_creacion DESC LIMIT :inicio, :porPagina");
    $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Configuración de paginación
$porPagina = 5; // Número de entradas por página
$totalEntradas = obtenerTotalEntradas();
$totalPaginas = ceil($totalEntradas / $porPagina);

// Página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$paginaActual = max(min($paginaActual, $totalPaginas), 1);

// Obtener las entradas de la página actual
$entradas = obtenerEntradasPaginadas($paginaActual, $porPagina);

// Cierre de conexión
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/pag.css">
    <title>Listado de Entradas</title>
</head>

<body>
    <center>
        <h2>Listado de Entradas</h2>
    </center>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Contenido</th>
            <th>Fecha de Creación</th>
            <th>ID Usuario</th>
            <th>Imagen</th>
        </tr>

        <?php foreach ($entradas as $entrada) : ?>
            <tr>
                <td><?php echo $entrada['id']; ?></td>
                <td><?php echo $entrada['titulo']; ?></td>
                <td><?php echo $entrada['contenido']; ?></td>
                <td><?php echo $entrada['fecha_creacion']; ?></td>
                <td><?php echo $entrada['id_usuario']; ?></td>
                <td>
                    <?php if (!empty($entrada['imagen'])) : ?>
                        <img src="<?php echo $entrada['imagen']; ?>" alt="Imagen de entrada" style="max-width: 50px;">
                    <?php else : ?>
                        Sin imagen
                    <?php endif; ?>
                </td>
                
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <span>Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?></span>
        <?php if ($paginaActual > 1) : ?>
            <a href="?pagina=<?php echo $paginaActual - 1; ?>">&laquo; Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
            <a href="?pagina=<?php echo $i; ?>" <?php echo ($i == $paginaActual) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($paginaActual < $totalPaginas) : ?>
            <a href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente &raquo;</a>
        <?php endif; ?>
    </div>
</body>

</html>
