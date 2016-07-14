<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);
?>



<?php
/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"])){


	
$sql = $con->query("INSERT INTO usuarios(Rut_Usuario,Nombre_Usuario,Apellido_Usuario,Clave_Acceso,Tipo_Usuario) VALUES('".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape']."','".$_POST['clave']."','".$_POST['tipouser']."')");
echo"<script>alert('Se ha Ingresado con Éxito');
 document.location.href='personaladmin.php'</script>";	
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql2 = $con->query("UPDATE usuarios SET Nombre_Usuario='".$_POST['nom']."',Apellido_Usuario='".$_POST['ape']."',Clave_Acceso='".$_POST['clave']."',Tipo_Usuario='".$_POST['tipouser']."' WHERE rut_Usuario='".$_POST['rut']."'");	
echo"<script>alert('Se ha Editado con Éxito');
 document.location.href='personaladmin.php'</script>";		
}

/* ELIMINAR CLIENTE */


if(isset($_POST["btneliminar"])) {
	
$sql3= $con->query("DELETE FROM usuarios WHERE Rut_Usuario='".$_POST['rut']."'");
echo"<script>alert('Se ha Eliminado con Éxito');
 document.location.href='personaladmin.php'</script>";	

}

// eliminar producto del detalle
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM usuarios WHERE Rut_Usuario='". $_GET['eliminar'] ."'");
	
	header('Location: personaladmin.php');
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
		<title>Admin. Personal</title>
        
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
            <div class="titulo"><label class="letratitulo1">Personal</label></div>
            
            <div class="tablas">

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class='letratabla'>Rut</th>
				<th class='letratabla'>Nombre</th>
                <th class='letratabla'>Apellido</th>
				<th class='letratabla'>Clave</th>
				<th class='letratabla'>Tipo Usuario</th>
				<th class='letratabla'>Eliminar</th>
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                  <th class='letratabla'>Rut</th>
				<th class='letratabla'>Nombre</th>
                <th class='letratabla'>Apellido</th>
				<th class='letratabla'>Clave</th>
				<th class='letratabla'>Tipo Usuario</th>
				<th class='letratabla'>Eliminar</th>
              
				
              
            </tr>
        </tfoot>
		<tbody>
        <?php $sql4 = $con->query("SELECT * FROM usuarios");
		while($detalle= $sql4->fetch_array()){
			
		
		
		
			echo"<tr>
			
				<td class='letratabla2'><center>".$detalle['Rut_Usuario']."</center></td>
                <td class='letratabla'><center>".$detalle['Nombre_Usuario']."</center></td>
				<td class='letratabla2'><center>".$detalle['Apellido_Usuario']."</center></td>
				<td class='letratabla'><center>".$detalle['Clave_Acceso']."</center></td>
				<td class='letratabla2'><center>".$detalle['Tipo_Usuario']."</center></td>
               <td class='letratabla'><a href='personaladmin.php?eliminar=".$detalle['Rut_Usuario']."'><center><img src='img/basurero.jpg'></center></a></td>
                
            </tr>";
			
            }?>
            </tbody>
    </table>

</div>
            
            
            <div class="formuclientes">
           
            <form action="personaladmin.php" method="post" name="formuproducto">
           
            
            <table>
            <tr>
            <td colspan="2"> <label class="letraprod">Cliente :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >RUT</label></td> <td><input type="text" id="buscar_personal" name="rut" class="cajatexto" placeholder="Busqueda e Ingreso Sin Puntos ni Guión" required></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Nombre :</label></td> <td><input type="text" id="nom" name="nom" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Apellido :</label></td> <td><input type="text" name="ape" id="ape"  class="cajatexto" required ></td>
            </tr>

             <tr>
            <td><label class="letraprod">Clave :</label></td> <td><input type="password" name="clave" id="clave"  class="cajatexto" required></td>
            </tr>
              <tr>
            <td><label class="letraprod">Tipo Usuario :</label></td> <td><select name="tipouser" id="tipouser"   class="cajatexto"> 
         
    <option value="Administrador">Administrador</option>     
    <option value="Personal">Personal</option>   
            
           
            </select>
           </td>
            </tr>
            <tr>
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod"><input type="submit" name="btneditar" value="Editar" class="botonprod"><input type="submit" name="btneliminar" value="Eliminar" class="botonprod"></td>
            </tr>
            </table>
            
            </form>
            
         
            
            </div>
            
            </div>

		

		
		</div><!--/con-princ-->
 <div class="titulo"><label class="letratitulo1">Personal</label></div>
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
			$('#buscar_personal').keyup(function()
			{
				$.ajax({
					url: 'info_personal.php',
					type: 'post',
					data: {buscar_personal:$('#buscar_personal').val()},
					dataType:'json',
					success: function(personal)
					{
						if ( personal ) // Encontro el producto?
						{
							
							$('#rut').val(personal.Rut_Usuario);
							$('#nom').val(personal.Nombre_Usuario);
							$('#ape').val(personal.Apellido_Usuario);
							$('#clave').val(personal.Clave_Acceso);
							$('#tipouser').val(personal.Tipo_Usuario);
							
							
						}
						else // Producto no existe
						{
							
								$('#rut').val('');
							$('#nom').val('');
							$('#ape').val('');
							$('#clave').val('');
							$('#tipouser').val('');
							
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

