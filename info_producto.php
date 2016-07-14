<?php
include 'base_de_datos.php';

if ( !isset($_POST['codigo_producto'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// Sacar informacion de producto
	$consulta = $mysqli->query("SELECT descripcion, precio, porcentaje_descuento, stock FROM productos WHERE codigo_producto='". $_POST['codigo_producto'] ."'");

	$producto = $consulta->fetch_array();

    echo json_encode($producto);
	


	$mysqli->close();
}
?>