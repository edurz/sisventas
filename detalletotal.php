<?php
include 'base_de_datos.php';

if ( !isset($_GET['id_eliminado'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// detalle de venta
	$consulta = $mysqli->query("DELETE FROM mnotad WHERE id_nota_detalle='". $_GET['id_eliminado'] ."'");
	
$eliminado= $_GET['id_eliminado'];	
$total= $_GET['totalve'];
$totalfinal= $total - $eliminado;

	
	echo'$totalfinal';
	
}

	$mysqli->close();


/*
		echo '<center><table border="1">';
		echo '<tr><td>Codigo Producto</td><td>Cantidad Producto</td><td>Eliminar</td></tr>';

		while($detalle = $consulta->fetch_array())
		{
			echo '<tr>'
					.'<td>'. $detalle['codigo_producto'] .'</td>'
					.'<td>'. $detalle['cantidad_producto'] .'</td>'
					.'<td><a href="index.php?eliminar='. $detalle['id_nota_detalle'] .'"><img src="img/btneliminar.png"></a></td>'
				.'</tr>';
		}
		echo '</table></center>';
	}
	else // no hay detalle
	{
		echo '<center><label class="letradet">No hay productos agregados</label></center>';
	*/

?>

<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css" />
<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="datatable/jquery.dataTables.min.js"></script>




<style>
table{
	border:#03C;
}
tr,td{
	font-family:Arial, Helvetica, sans-serif;
	font-size:24px;
	}
.letradet{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	
}
</style>
</head>
<body>


<script type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable( {
        "scrollY":        "340px",
        "scrollCollapse": true,
        "paging":         false,
		 "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "No se Encontraron Registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No Hay Registros en la Tabla",
            "infoFiltered": "(Filtrado desde _MAX_ Registros en Total)",
			"search": "Buscar"
        }
    } );
} );
</script>





</body>


</html>

