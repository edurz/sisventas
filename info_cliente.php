<?php
include 'base_de_datos.php';

if ( !isset($_POST['buscar_cliente'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// Sacar informacion de producto
	$consulta = $mysqli->query("SELECT * FROM clientes WHERE rut_cliente='". $_POST['buscar_cliente'] ."'");

	$cliente= $consulta->fetch_array();

    echo json_encode($cliente);
	


	$mysqli->close();
}
?>