<?php
include 'base_de_datos.php';



$con = @new mysqli(host, usuario, contrasena, nombre);

  if(isset($_COOKIE["usuario_nombre"])){ //SESION INICIADA ?
	 $usuario = unserialize($_COOKIE['usuario_nombre']);
	$vendedor= $usuario['nombre']; 
  }


	
	// VENTA DESPACHADA
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM admindespacho WHERE id_despacho='". $_GET['eliminar'] ."'");
	echo"<script>alert('Despachado con Éxito');
 document.location.href='despachos.php'</script>";
}
		   
	// ANULAR DESPACHO
if ( isset($_GET['notav']) )
{
	$con->query("DELETE FROM admindespacho WHERE id_nota_venta='". $_GET['notav'] ."'");
	$con->query("DELETE FROM despacho WHERE id_nota_venta='". $_GET['notav'] ."'");
	$con->query("DELETE FROM mnotae WHERE Id_Nota_Venta='". $_GET['notav'] ."'");
	$con->query("DELETE FROM mnotad WHERE Id_Nota_Venta='". $_GET['notav'] ."'");
	echo"<script>alert('Despacho Anulado');
 document.location.href='despachos.php'</script>";
}		   

$sqldespacho = $con->query("SELECT MAX( id_despacho ) AS  `ID_DES` FROM despacho");
					$resul = $sqldespacho->fetch_array();
					$coddes=$resul["ID_DES"];
					$coddes= $coddes + 1;

/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btnvender"])){
	
$sql = $con->query("INSERT INTO despacho(id_despacho,id_nota_venta,rut_cliente,nombre_cliente,ape_paterno,ape_materno,direccion,num_dir,comuna,telefono,total,efectivo,vuelto,fecha) VALUES('$coddes','".$_POST['codventa']."','".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape1']."','".$_POST['ape2']."','".$_POST['dir']."','".$_POST['num']."','".$_POST['comu']."','".$_POST['tel']."','".$_POST['total']."','".$_POST['efec']."','".$_POST['vuel']."',CURDATE())");

$con->query("INSERT INTO mnotae (Id_Nota_Venta,Fecha_Nota_Venta,Tipo_Venta,Vendedor,Codigo_Despacho,Total_Venta,Efectivo,Vuelto) VALUES ('".$_POST['codventa']."',CURDATE(),'Efectivo','$vendedor','$coddes','".$_POST['total']."','".$_POST['efec']."','".$_POST['vuel']."')");
$cventa=$_POST['codventa'];
$tventa=$_POST['total'];
$efec=$_POST['efec'];
$vuel=$_POST['vuel'];
echo"<script type='text/javascript'>alert('Ingreso Con Éxito')</script>";
header("location:notadespacho.php?codigo_venta=$cventa&cod_des=$coddes&vend=$vendedor&total=$tventa&ef=$efec&vue=$vuel");
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql2 = $con->query("UPDATE clientes SET nombre_cliente='".$_POST['nom']."',apellido_paterno='".$_POST['ape1']."',apellido_materno='".$_POST['ape2']."',telefono='".$_POST['tel']."',direccion='".$_POST['dir']."',numeracion_dir='".$_POST['num']."',comuna='".$_POST['comu']."'WHERE rut_cliente='".$_POST['rut']."'");	
	
}

/* ELIMINAR CLIENTE */


if(isset($_POST["btneliminar"])) {
	
$sql3= $con->query("DELETE FROM clientes WHERE rut_cliente='".$_POST['rut']."'");


}

?>


<!doctype html>
<html>
	<head>
        <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
        <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">
		<title>Despachos</title>
        
        <style>
		.tabladetalleventa{
			height:600px;
			width:auto;
			margin:60px;
			margin-left:160px;
			float:left;	
		}
		
		.div-despacho{
			width:auto;
	background:#FFF;
	height:800px;
		}
		.producto{
			height:450px;
			width:660px;
			background-color:#CCC;
			margin:10px;
			float:left;
			}
		.producto td{
			height:30px;
			width: 150px;
			
		}
			
		.letraprod{
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
		.cajatexto{
			width:350px;
			height:30px;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
		.botonprod{
			height:35px;
			width:100px;
			color:#09C;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
		}
		.botoncaja{
			float:left;
			width:200px;
			height:40px;	
		}
		.botondesp{ 
 
			height:35px;
			width:115px;
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
       
		<div id="con-princ">
			 <div class="titulo"><label class="letratitulo1">Estado de Despachos</label></div>

		  <div class="div-despacho">
            
            <div class="tabladetalleventa">
            
           <?php  
		  
           $sqldetalle = $con->query("SELECT * FROM admindespacho");
	
	

	if ( $sqldetalle->num_rows > 0 )  // hay productos agregados?
	{ 
	echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">N° Despacho</th>
				<th class="letratabla">Nota Venta</th>
                <th class="letratabla">Nombre Cliente</th>
				<th class="letratabla">Apellidos</th>
				<th class="letratabla">Dirección</th>
				<th class="letratabla">Comuna</th>
				<th class="letratabla">Telefono</th>
				<th class="letratabla">Total</th>
				<th class="letratabla">Efectivo</th>
				<th class="letratabla">Vuelto</th>
				<th class="letratabla">Fecha</th>
				<th class="letratabla">Acciones</th>
				<th class="letratabla">Detalle</th>
				
               
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
               <th class="letratabla">N° Despacho</th>
				<th class="letratabla">Nota Venta</th>
                <th class="letratabla">Nombre Cliente</th>
				<th class="letratabla">Apellidos</th>
				<th class="letratabla">Dirección</th>
				<th class="letratabla">Comuna</th>
				<th class="letratabla">Telefono</th>
				<th class="letratabla">Total</th>
				<th class="letratabla">Efectivo</th>
				<th class="letratabla">Vuelto</th>
				<th class="letratabla">Fecha</th>
				<th class="letratabla">Acciones</th>
				<th class="letratabla">Detalle</th>
				
                
				
              
            </tr>
        </tfoot>
		<tbody>';
		
		while($detalle = $sqldetalle->fetch_array())
		{
			
			echo'<tr>
                <td class="letratabla"><center>'.$detalle['id_despacho'].'</center></td>
				<td class="letratabla2"><center>'.$detalle['id_nota_venta'].'</center></td>
                <td class="letratabla"><center>'.$detalle['nombre_cliente'].'</center></td>
				<td class="letratabla2"><center>'.$detalle['ape_paterno'].' '.$detalle['ape_materno'].' </center></td>
				<td class="letratabla"><center>'.$detalle['direccion'].' N°: '.$detalle['num_dir'].'</center></td>
				<td class="letratabla2"><center>'.$detalle['comuna'].'</center></td>
              <td class="letratabla"><center>'.$detalle['telefono'].'</center></td>
			  <td class="letratabla2"><center>'.$detalle['total'].'</center></td>
			  ';
			  if($detalle['efectivo']==0){
				  echo'<td class="letratabla"><center>POR PAGAR</center></td>
				  <td class="letratabla2"><center>0</center></td>';
			  }else{echo'
			  <td class="letratabla"><center>'.$detalle['efectivo'].'</center></td>
			  <td class="letratabla2"><center>'.$detalle['vuelto'].'</center></td>
			  ';}
			 echo'<td class="letratabla"><center>'.$detalle['fecha'].'</center></td>
			  <td><center><a href="despachos.php?eliminar='.$detalle['id_despacho'].'"><input type="button" class="botondesp" value="Despachado"></a><a href="despachos.php?notav='.$detalle['id_nota_venta'].'"><input type="button" class="botondesp" value="Anular"></a></td></center>
			  
		       <td><center><a href="detalledespacho.php?codvent='.$detalle['id_nota_venta'].'&coddes='.$detalle['id_despacho'].'"><img src="img/detalledesp.png"></a></td>
			  
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
	}else{
		echo"<center>no hay despachos pendientes</center>";
		
	    }
	
	
           
           ?>
            
            </div>
           
         
            </div>

		

		
		</div><!--/con-princ-->

		<?php
		$con->close();
		?>

		

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