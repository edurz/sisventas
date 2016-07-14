<?php
include 'base_de_datos.php';

if ( !isset($_GET['codigo_venta'])) exit;

// Conectar base de datos
$mysqli = @new mysqli(host, usuario, contrasena, nombre);

if ( $mysqli->connect_error ) // Error ?
{
	echo 'Error: '. $mysqli->connect_error;
}
else // Conexion Ok
{
	// detalle de venta
	$consulta = $mysqli->query("SELECT id_nota_detalle, codigo_producto, cantidad_producto, porcentaje_descuento, precio_unitario_venta, subtotal FROM mnotad WHERE id_nota_venta='". $_GET['codigo_venta'] ."'");
	
	

	if ( $consulta->num_rows > 0 )  // hay productos agregados?
	{ 
	echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Codigo Producto</th>
				<th>Producto</th>
                <th>Cantidad Producto</th>
				<th>Precio Unitario</th>
				<th>Descuento</th>
				<th>Sub Total</th>
                <th>Eliminar</th>
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Codigo Producto</th>
				<th>Producto</th>
                <th>Cantidad Producto</th>
				<th>Precio Unitario</th>
				<th>Descuento</th>
				<th>Sub Total</th>
                <th>Eliminar</th>
				
              
            </tr>
        </tfoot>
		<tbody>';
		while($detalle = $consulta->fetch_array())
		{
			$consulta2 = $mysqli->query("SELECT Descripcion FROM productos WHERE Codigo_Producto = '".$detalle['codigo_producto']."'");
			$detalle2= $consulta2->fetch_array();
			echo'<tr>
                <td><center>'.$detalle['codigo_producto'].'</center></td>
				<td><center>'.$detalle2['Descripcion'].'</center></td>
                <td><center>'.$detalle['cantidad_producto'].'</center></td>
				<td><center>'.$detalle['precio_unitario_venta'].'</center></td>
				<td><center>'.$detalle['porcentaje_descuento'].'%</center></td>
				<td><center>'.$detalle['subtotal'].'</center></td>
               <td><a href="caja.php?eliminar='.$detalle['id_nota_detalle'].'"><center><img src="img/btneliminar.png"></center></a></td>
                
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
	}

	$mysqli->close();
}

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

