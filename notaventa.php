<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);


$codvent = $_GET['codigo_venta'];
 $total= $_GET['totalve'];
 $ven= $_GET['vendedor'];
  $efec= $_GET['ef'];
   $vuel= $_GET['vue'];



	
	

 ?>
<table>
<tr>
<td>N° Nota Venta :</td><td><?=$codvent?></td>
</tr>
<tr>
<td>Atendido por :</td><td><?=$ven?></td>
</tr>


</table>

<?php     $sqldetalle = $con->query("SELECT * FROM mnotad WHERE Id_Nota_Venta='$codvent'");

if ( $sqldetalle->num_rows > 0 )  // hay productos agregados?
	{ 
	
?>
<table width="200" border="0">
  <tr>
    <th scope="col">Cod.</th>
    <th scope="col">Producto</th>
    <th scope="col">Cantidad</th>
     <th scope="col">Descuento</th>
    <th scope="col">Subtotal</th>
    
  </tr>
  
  <?php while($detalle= $sqldetalle->fetch_array())
  {
	  $sqldetalle2 = $con->query("SELECT Descripcion FROM productos WHERE Codigo_Producto = '".$detalle['Codigo_Producto']."'");
			$detalle2= $sqldetalle2->fetch_array();
 echo' 
  <tr>
   <td><center>'.$detalle['Codigo_Producto'].'</td>
				<td>'.$detalle2['Descripcion'].'</td>
                <td>'.$detalle['Cantidad_Producto'].'</td>
				<td>'.$detalle['Porcentaje_Descuento'].'%</td>
				<td>'.$detalle['Subtotal'].'</td>
  </tr>';
}
  ?>
  
  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Total</th>
    <th scope="col"><?=$total?></th>
  </tr>
  
   <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Efectivo</th>
    <th scope="col"><?=$efec?></th>
  </tr>
  
  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Vuelto</th>
    <th scope="col"><?=$vuel?></th>
  </tr>
</table>
<?php }?>
<a href="caja.php"><input type="button" value="caja" /></a>




</body>
</html>