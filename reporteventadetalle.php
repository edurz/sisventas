<?php // content="text/plain; charset=utf-8"

include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);
 





if(!isset($_GET["detallemes"]))exit;
$detmes=$_GET["detallemes"];



$mes= substr($detmes,5,2);
	
if($mes=="01"){
	$mes= "Enero";
}
if($mes=="02"){
	$mes= "Febrero";
}
if($mes=="03"){
	$mes= "Marzo";
}
if($mes=="04"){
	$mes= "Abril";
}
if($mes=="05"){
	$mes= "Mayo";
}
if($mes=="06"){
	$mes= "Junio";
}
if($mes=="07"){
	$mes= "Julio";
}
if($mes=="08"){
	$mes= "Agosto";
}
if($mes=="09"){
	$mes= "Septiembre";
}
if($mes=="10"){
	$mes= "Octubre";
}
if($mes=="11"){
	$mes= "Noviembre";
}
if($mes=="12"){
	$mes= "Diciembre";
}
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reportes</title>
 <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
         <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="css/styles.css">
 <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">


<style>
#contenido{
	margin-top:40px;
	height:800px;
	width:auto;
}

.botonprod{
			height:35px;
			width:100px;
			color:#09C;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
		}
</style>
</head>

<body>
  <?php if(isset($_COOKIE["usuario_nombre"])){ //SESION INICIADA ?
	 $usuario = unserialize($_COOKIE['usuario_nombre']);
	$vendedor= $usuario['nombre'];
echo "<img src='img/user.png'><label class='letrauser'> Bienvenido : " . $usuario['nombre'] .
"

</label><a href='logout.php'><img src='img/cerrar.png'></a>";

if($usuario['id']=='Administrador'){// VALIDAR PERMISO DE USUARIO


	echo"	<div id='cssmenu'>
			<ul>
   				<li><a href='login.php'><span>Home</span></a></li>
                
                <li><a href='caja.php'><span>Caja</span></a></li>
   				<li class='active has-sub'>
   					<a href='#'><span>Inventario</span></a>
      				<ul>
         				<li class='has-sub'><a href='#'><span>Productos</span></a>
            				<ul>
               					<li><a href='productos.php'><span>Ingresar Productos</span></a></li>
               					<li class='last'><a href='tipo_producto.php'><span>Ingresar Categoria</span></a></li>
            				</ul>
         				</li>
         				<li class='has-sub'><a href=''><span>Compras</span></a>
            				<ul>
               					<li><a href='compras.php'><span>Ingresar</span></a></li>
               					<li><a href='proveedores.php'><span>Proveedores</span></a></li>
            				</ul>
							
               					
            				
         				</li>
                       
      				</ul>
   				</li>
   				
                <li class='has-sub'><a href='#'><span>Usuarios</span></a>
            				<ul>
               					<li><a href='personaladmin.php'><span>Personal</span></a></li>
               					
            				
               					<li><a href='clientesadmin.php'><span>Clientes</span></a></li>
               					
            				</ul>
         				</li>
   				
				 <li><a href='despachos.php'><span>Despachos</span></a></li>
			   
			   <li class='active has-sub'>
   					<a href='#'><span>Reportes</span></a>
      				<ul>
         				<li class='has-sub'><a href='reportes.php'><span>Ventas</span></a></li>
            		</ul>
			   </li>
		</div>
";}
if($usuario['id']=='Personal'){
	echo"	<div id='cssmenu'>
			<ul>
			    <li><a href='caja.php'><span>Caja</span></a></li>
   				<li><a href='clientes.php'><span>Clientes</span></a></li>
				<li><a href='despachos.php'><span>Despachos</span></a></li>
				</ul>
				</div>";
				
}
}else{
echo"<script type='text/javascript'>alert('Por Favor Iniciar Sesion'); window.location='login.php'</script>";	
	
}
?>
<div class="titulo"><label class="letratitulo1">Detalle de Ventas Correspondiente a <?=$mes?></label></div>
<div id="contenido">


<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class='letratabla'>Nota de Venta</th>
				<th class='letratabla'>Código Producto</th>
                <th class='letratabla'>Cantidad</th>
                <th class='letratabla'>Precio</th>
                <th class='letratabla'>Descuento</th>
                <th class='letratabla'>Precio c/dscto</th>
                <th class='letratabla'>Subtotal</th>
                
            
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                 <th class='letratabla'>Nota de Venta</th>
				<th class='letratabla'>Código Producto</th>
                <th class='letratabla'>Cantidad</th>
                <th class='letratabla'>Precio</th>
                <th class='letratabla'>Descuento</th>
                <th class='letratabla'>Monto %</th>
                <th class='letratabla'>Subtotal</th>
				
              
            </tr>
        </tfoot>
		<tbody>
        
        


<?php

$sql2= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$detmes'");
while($idventa= $sql2->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql3= $con->query("SELECT * FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql3->fetch_array())
     {
		 $idnotav = $idprod["Id_Nota_Venta"];
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $precio= $idprod["Precio_Unitario_Venta"];
		 $desc= $idprod["Porcentaje_Descuento"];
		 $montodesc= $idprod["Monto_Descuento"];
		 $subtotal= $idprod["Subtotal"];
		  
  
echo"<tr>
		        <td class='letratabla'><center>".$idnotav."</center></td>
				<td class='letratabla2'><center>".$idp."</center></td>
				<td class='letratabla'><center>".$cantprod."</center></td>
				<td class='letratabla2'><center>".$precio."</center></td>
				<td class='letratabla'><center>".$desc."%</center></td>
				<td class='letratabla2'><center>".$montodesc."</center></td>
				<td class='letratabla'><center>".$subtotal."</center></td>
				</tr>
				
				";
				   }
}
	
?>
   </tbody>
    </table>

</div>


<script type="text/javascript">
		$(document).ready(function()
		{
			
			
			
			  $("#tabs").tabs( {
        "activate": function(event, ui) {
            $( $.fn.dataTable.tables( true ) ).DataTable().columns.adjust();
        }
    } );
     
    $('table.display').dataTable( {
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false,
        "jQueryUI": true,
		"language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "No se Encontraron Registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No Hay Registros en la Tabla",
            "infoFiltered": "(Filtrado desde _MAX_ Registros en Total)",
			"search": "Buscar"
        }
    } );
	
	
	
		});
		</script>
</body>
</html>