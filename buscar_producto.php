<?php
include 'base_de_datos.php';

if ( !isset($_POST['buscar_producto'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// Sacar informacion de producto
	$consulta = $mysqli->query("SELECT * FROM productos WHERE Codigo_Producto='". $_POST['buscar_producto'] ."'");

	$producto= $consulta->fetch_array();

    echo json_encode($producto);
	


	$mysqli->close();
}
?>