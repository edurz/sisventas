<?php
include 'base_de_datos.php';

if ( !isset($_GET['codigo_venta'])&&!isset($_GET['totalve']))
{
	echo"<script language='javascript' type='text/javascript'>alert('Debes acceder al despacho por la caja')</script>";
	header("Location: caja.php");
}

$con = @new mysqli(host, usuario, contrasena, nombre);

  if(isset($_COOKIE["usuario_nombre"])){ //SESION INICIADA ?
	 $usuario = unserialize($_COOKIE['usuario_nombre']);
	$vendedor= $usuario['nombre']; 
  }

 $codvent = $_GET['codigo_venta'];
		   $total= $_GET['totalve'];
		   
		   

$sqldespacho = $con->query("SELECT MAX( id_despacho ) AS  `ID_DES` FROM despacho");
					$resul = $sqldespacho->fetch_array();
					$coddes=$resul["ID_DES"];
					$coddes= $coddes + 1;

/* --------INGRESAR VENTA -------------*/
if(isset($_POST["btnvender"])){
	
$sql = $con->query("INSERT INTO despacho(id_despacho,id_nota_venta,rut_cliente,nombre_cliente,ape_paterno,ape_materno,direccion,num_dir,comuna,telefono,total,efectivo,vuelto,fecha) VALUES('$coddes','".$_POST['codventa']."','".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape1']."','".$_POST['ape2']."','".$_POST['dir']."','".$_POST['num']."','".$_POST['comu']."','".$_POST['tel']."','".$_POST['total']."','".$_POST['efec']."','".$_POST['vuel']."',CURDATE())");

$con->query("INSERT INTO admindespacho(id_despacho,id_nota_venta,rut_cliente,nombre_cliente,ape_paterno,ape_materno,direccion,num_dir,comuna,telefono,total,efectivo,vuelto,fecha) VALUES('$coddes','".$_POST['codventa']."','".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape1']."','".$_POST['ape2']."','".$_POST['dir']."','".$_POST['num']."','".$_POST['comu']."','".$_POST['tel']."','".$_POST['total']."','".$_POST['efec']."','".$_POST['vuel']."',CURDATE())");

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
		<title>Despacho</title>
        
        <style>
		.tabladetalleventa{
			height:500px;
			width:900px;
			margin:10px;
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
			background-color:#fff;
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
			 <div class="titulo"><a href="caja.php"><img class="botoncaja" src="img/caja.png"></a><label class="letratitulo1">Despacho</label></div>

		  <div class="div-despacho">
            
            <div class="tabladetalleventa">
            
           <?php  
		  
           $sqldetalle = $con->query("SELECT id_nota_detalle, codigo_producto, cantidad_producto, porcentaje_descuento, precio_unitario_venta, subtotal FROM mnotad WHERE id_nota_venta='$codvent'");
	
	

	if ( $sqldetalle->num_rows > 0 )  // hay productos agregados?
	{ 
	echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">Codigo Producto</th>
				<th class="letratabla">Producto</th>
                <th class="letratabla">Cantidad Producto</th>
				<th class="letratabla">Precio Unitario</th>
				<th class="letratabla">Descuento</th>
				<th class="letratabla">Sub Total</th>
               
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                 <th class="letratabla">Codigo Producto</th>
				<th class="letratabla">Producto</th>
                <th class="letratabla">Cantidad Producto</th>
				<th class="letratabla">Precio Unitario</th>
				<th class="letratabla">Descuento</th>
				<th class="letratabla">Sub Total</th>
                
				
              
            </tr>
        </tfoot>
		<tbody>';
		
		while($detalle = $sqldetalle->fetch_array())
		{
			$sqldetalle2 = $con->query("SELECT Descripcion FROM productos WHERE Codigo_Producto = '".$detalle['codigo_producto']."'");
			$detalle2= $sqldetalle2->fetch_array();
			echo'<tr>
                <td class="letratabla"><center>'.$detalle['codigo_producto'].'</center></td>
				<td class="letratabla2"><center>'.$detalle2['Descripcion'].'</center></td>
                <td class="letratabla"><center>'.$detalle['cantidad_producto'].'</center></td>
				<td class="letratabla2"><center>'.$detalle['precio_unitario_venta'].'</center></td>
				<td class="letratabla"><center>'.$detalle['porcentaje_descuento'].'%</center></td>
				<td class="letratabla2"><center>'.$detalle['subtotal'].'</center></td>
              
		        
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
	}else{
		echo"no hay productos agregados";
		
	    }
	
	
           
           ?>
            
            </div>
           
            <div class="producto">
            
            <form action="despacho.php" method="post" name="formuproducto">
            
            <table>
             <tr>
            <td colspan="2"> <label class="letratitulo2">Venta Asociada :</label></td>
            </tr>
           <tr>
            <td><label class="letraprod" >N° Despacho :</label></td> <td><input type="number" class="cajatexto" value="<?=$coddes?>" required readonly></td>
            </tr>
            <tr>
            <td><label class="letraprod" >N° Venta :</label></td> <td><input type="number" class="cajatexto" value="<?=$codvent?>" name="codventa" required readonly></td>
            </tr>
            
            <tr>
            <td colspan="2"> <label class="letraprod">Cliente :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >RUT</label></td> <td><input type="number" id="buscar_cliente" name="rut" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Nombre :</label></td> <td><input type="text" id="nom" name="nom" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Apellido Paterno:</label></td> <td><input type="text" name="ape1" id="ape1"  class="cajatexto" required ></td>
            </tr>
            <tr>
            <td><label class="letraprod">Apellido Materno :</label></td> <td><input type="text" name="ape2" id="ape2"  class="cajatexto" required></td>
            </tr>
            
            <tr>
            <td><label class="letraprod">Dirección :</label></td> <td><input type="text" name="dir" id="dir"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Numeración :</label></td> <td><input type="number" name="num" id="num"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Teléfono  :</label></td> <td><input type="number" name="tel" id="tel"  class="cajatexto" required></td>
            </tr>
             <tr>
            <td><label class="letraprod">Comuna :</label></td> <td><input type="text" name="comu" id="comu"  class="cajatexto" required></td>
            </tr>
            
           <tr>
           <td></td>
           </tr>
           
           <tr>
            <td><label class="letraprod" >Total venta :</label></td> <td><input type="number" class="cajatexto" name="total" id="total" value="<?=$total?>" required readonly></td>
            </tr>
              
           <tr>
            <td><label class="letraprod" >Efectivo :</label></td> <td><input type="number" class="cajatexto" name="efec" id="efectivo" required></td>
            </tr>
             <tr>
            <td><label class="letraprod" >Vuelto :</label></td> <td> <input type="number" class="cajatexto" name="vuel" id="vuelto" required readonly></td>
            </tr>
           
            <tr>
            <td></td> <td><input type="submit" name="btnvender" value="Vender" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
         
            
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
        "scrollY": "200px",
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
			
			$('#buscar_cliente').keyup(function()
			{
				$.ajax({
					url: 'info_cliente.php',
					type: 'post',
					data: {buscar_cliente:$('#buscar_cliente').val()},
					dataType:'json',
					success: function(cliente)
					{
						if ( cliente ) // Encontro el producto?
						{
							
							
							$('#nom').val(cliente.nombre_cliente);
							$('#ape1').val(cliente.apellido_paterno);
							$('#ape2').val(cliente.apellido_materno);
							$('#tel').val(cliente.telefono);
							$('#dir').val(cliente.direccion);
							$('#num').val(cliente.numeracion_dir);
							$('#comu').val(cliente.comuna);
							
						}
						else // Producto no existe
						{
							
							
							$('#nom').val('');
							$('#ape1').val('');
							$('#ape2').val('');
							$('#tel').val('');
							$('#dir').val('');
							$('#num').val('');
							$('#comu').val('');
							
							
						}
					}
				});
			});

			$("#efectivo").keyup(function()
			{
				var resul= parseInt($("#efectivo").val()) - parseInt($("#total").val());
			
				$("#vuelto").val(resul);
			});
		});
		</script>

	</body>
</html>