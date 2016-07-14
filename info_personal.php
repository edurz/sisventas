<?php
include 'base_de_datos.php';

if ( !isset($_POST['buscar_personal'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// Sacar informacion de producto
	$consulta = $mysqli->query("SELECT * FROM usuarios WHERE Rut_Usuario='". $_POST['buscar_personal'] ."'");

	$personal= $consulta->fetch_array();

    echo json_encode($personal);
	


	$mysqli->close();
}
?>