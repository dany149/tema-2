<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "bdblog";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES utf8");

    $mensaje = "Conectado a la Base de Datos bdBlog!! :)";
} catch (PDOException $e) {
    $mensaje = "Error de conexión: " . $e->getMessage();
    die();
}
?>
