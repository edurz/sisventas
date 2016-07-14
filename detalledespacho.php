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


$idvent = $_GET['codvent'];
 $iddes= $_GET['coddes'];
 

 
if(isset($_COOKIE["usuario_nombre"])){ //SESION INICIADA ?
	 $usuario = unserialize($_COOKIE['usuario_nombre']);
	$vendedor= $usuario['nombre']; 
  }



	
	

 ?>
 <label>-----------------------------------------------------------------------</label><br />
<table>
<tr>
<td>N° Nota Venta :</td><td><?=$idvent?></td>
</tr>

<tr>
<td>Atendido por :</td><td><?=$vendedor?></td>
</tr>


</table>

<?php     $sqldetalle = $con->query("SELECT * FROM mnotad WHERE Id_Nota_Venta='$idvent'");

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


$sql= $con->query("SELECT Total_Venta,Efectivo,Vuelto FROM mnotae WHERE Id_Nota_Venta = '$idvent'");
$dettotal = $sql->fetch_array();
  ?>
  
  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Total</th>
    <th scope="col"><?=$dettotal["Total_Venta"]?></th>
  </tr>
  
  <?php if($dettotal["Efectivo"] == 0){
	echo'<tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col"></th>
    <th scope="col">POR CANCELAR</th>
  </tr>';  
  }else{
	echo'  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Efectivo</th>
    <th scope="col">'.$dettotal["Efectivo"].'</th>
  </tr>
  
  <tr>
    <th scope="col"></th>
    <th scope="col"></th>
    <th scope="col"></th>
     <th scope="col">Vuelto</th>
    <th scope="col">'.$dettotal["Vuelto"].'</th>
  </tr>';  
  }?>
  
 
</table>
<?php }

$sqlcliente = $con->query("SELECT * FROM despacho WHERE id_despacho='$iddes'");
$detallecli= $sqlcliente->fetch_array();

?>

<label>------------------------------Cliente---------------------------------</label>
<table>

<tr>
<td>Orden Despacho :</td><td><?=$iddes?></td>
</tr>

<tr>
<td>Nombre :</td><td><?=$detallecli["nombre_cliente"]?></td>
</tr>
<tr>
<td>Apellidos :</td><td><?=$detallecli["ape_paterno"]?> <?=$detallecli["ape_materno"]?></td>
</tr>
<tr>
<td>Telefono :</td><td><?=$detallecli["telefono"]?></td>
</tr>
<tr>
<td>Dirección :</td><td><?=$detallecli["direccion"]?> <?=$detallecli["num_dir"]?>, <?=$detallecli["comuna"]?></td>
</tr>

</table>
<label>-----------------------------------------------------------------------</label><br />
<a href="despachos.php"><input type="button" value="Despahos" /></a>




</body>
</html>