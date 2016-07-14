<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"])){
	
$sql = $con->query("INSERT INTO clientes(rut_cliente,nombre_cliente,apellido_paterno,apellido_materno,telefono,direccion,numeracion_dir,comuna) VALUES('".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape1']."','".$_POST['ape2']."','".$_POST['tel']."','".$_POST['dir']."','".$_POST['num']."','".$_POST['comu']."')");
echo"<script>alert('Se ha Ingresado con Éxito');
 document.location.href='clientesadmin.php'</script>";	
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql2 = $con->query("UPDATE clientes SET nombre_cliente='".$_POST['nom']."',apellido_paterno='".$_POST['ape1']."',apellido_materno='".$_POST['ape2']."',telefono='".$_POST['tel']."',direccion='".$_POST['dir']."',numeracion_dir='".$_POST['num']."',comuna='".$_POST['comu']."'WHERE rut_cliente='".$_POST['rut']."'");	
echo"<script>alert('Se ha Editado con Éxito');
 document.location.href='clientesadmin.php'</script>";		
}

/* ELIMINAR CLIENTE */


if(isset($_POST["btneliminar"])) {
	
$sql3= $con->query("DELETE FROM clientes WHERE rut_cliente='".$_POST['rut']."'");
echo"<script>alert('Se ha Eliminado con Éxito');
 document.location.href='clientesadmin.php'</script>";	
}

// eliminar producto del detalle
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM clientes WHERE rut_cliente='". $_GET['eliminar'] ."'");
	
	header('Location: clientesadmin.php');
}



?>


<!doctype html>
<html>
	<head>
      <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
         <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
		<meta charset='utf-8'>
        <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">
		<title>Admin. clientes</title>
        
        <style>
		#cont{
	background:#CCC;
	width:auto;
	height:800px;
	margin-top:10px;	
}
#detallecli{
	width:auto;
	background:#CCC;
	height:500px;

}
		.formuclientes{
			height:550px;
			width:660px;
			background-color:#CCC;
			margin:0 auto;
			padding:30px;
			float:left;
			}
		.producto td{
			height:30px;
			width: 150px;
			
		}
		.tablas{
			height:550px;
			width:auto;
			background-color:#CCC;
			margin:0 auto;
			float:left;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
			}
			
		.titulo{
			width:auto;
			height:40px;
			background:#0CC;
			text-align:center;
			font-family:"Arial Black", Gadget, sans-serif;
			font-size:18px;	
		}
			
		.letraprod{
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
			.letrauser{
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
			color:#09C;
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
       
		<div id="cont">
			

			<div id="detallecli">
            <div class="titulo"><label class="letratitulo1">Clientes</label></div>
            
            <div class="tablas">

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class='letratabla'>Rut</th>
				<th class='letratabla'>Nombre</th>
                <th class='letratabla'>Apellido Paterno</th>
				<th class='letratabla'>Apellido Materno</th>
				<th class='letratabla'>Telefono</th>
				<th class='letratabla'>Direccion</th>
                <th class='letratabla'>Numeracion</th>
                <th class='letratabla'>Comuna</th>
                <th class='letratabla'>Eliminar</th>
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th class='letratabla'>Rut</th>
				<th class='letratabla'>Nombre</th>
                <th class='letratabla'>Apellido Paterno</th>
				<th class='letratabla'>Apellido Materno</th>
				<th class='letratabla'>Telefono</th>
				<th class='letratabla'>Direccion</th>
                <th class='letratabla'>Numeracion</th>
                <th class='letratabla'>Comuna</th>
                <th class='letratabla'>Eliminar</th>
				
              
            </tr>
        </tfoot>
		<tbody>
        <?php $sql4 = $con->query("SELECT * FROM clientes");
		while($detalle= $sql4->fetch_array()){
			
		
		
		
			echo"<tr>
			
				<td class='letratabla'><center>".$detalle['rut_cliente']."</center></td>
                <td class='letratabla2'><center>".$detalle['nombre_cliente']."</center></td>
				<td class='letratabla'><center>".$detalle['apellido_paterno']."</center></td>
				<td class='letratabla2'><center>".$detalle['apellido_materno']."</center></td>
				<td class='letratabla'><center>".$detalle['telefono']."</center></td>
				<td class='letratabla2'><center>".$detalle['direccion']."</center></td>
				<td class='letratabla'><center>".$detalle['numeracion_dir']."</center></td>
				<td class='letratabla2'><center>".$detalle['comuna']."</center></td>
               <td class='letratabla'><a href='clientesadmin.php?eliminar=".$detalle['rut_cliente']."'><center><img src='img/basurero.jpg'></center></a></td>
                
            </tr>";
			
            }?>
            </tbody>
    </table>

</div>
            
            
            <div class="formuclientes">
           
            <form action="" method="post" name="formuproducto">
           
            
            <table>
            <tr>
            <td colspan="2"> <label class="letraprod">Cliente :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >RUT</label></td> <td><input type="number" id="buscar_cliente" name="rut" class="cajatexto" placeholder="Busqueda o Ingreso" required></td>
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
            <td><label class="letraprod">Teléfono  :</label></td> <td><input type="number" name="tel" id="tel"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Dirección :</label></td> <td><input type="text" name="dir" id="dir"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Numeración :</label></td> <td><input type="number" name="num" id="num"  class="cajatexto" required></td>
            </tr>
             <tr>
            <td><label class="letraprod">Comuna :</label></td> <td><input type="text" name="comu" id="comu"  class="cajatexto" required></td>
            </tr>
           
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod"><input type="submit" name="btneditar" value="Editar" class="botonprod"><input type="submit" name="btneliminar" value="Eliminar" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
         
            
            </div>
            
            </div>

		

		
		</div><!--/con-princ-->
 <div class="titulo"><label class="letratitulo1">Clientes</label></div>
		<?php
		$con->close();
		?>

		

		<script type="text/javascript">
		$(document).ready(function()
		{
			/* cargar detalle
			$.ajax({
				url: 'detalle.php?codigo_venta=<?=$codvent?>',
				success: function(detalle)
				{
					$('#detalle').html(detalle);
				}
			})

			// Sacar informacion de producto
			*/
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
							
							$('#rut').val(cliente.rut_cliente);
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
							
							$('#rut').val('');
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
				var resul= parseInt($("#efectivo").val()) - parseInt($("#totalpagar").val());
			
				$("#vuelto").val(resul);
			});
			
			
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

