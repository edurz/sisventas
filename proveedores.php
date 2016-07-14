<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"])){
	
	$sql3= $con->query("SELECT nombre_prov FROM proveedores WHERE nombre_prov ='".$_POST['nom']."'");	
if($sql3->num_rows > 0){
	echo"<script>alert('Este código ya esta Ingresado')</script>";
}else{
$sql = $con->query("INSERT INTO proveedores(nombre_prov,telefono,email,direccion) VALUES('".$_POST['nom']."','".$_POST['tel']."','".$_POST['email']."','".$_POST['dir']."')");
echo"<script>alert('Ingreso con Éxito');
 document.location.href='proveedores.php'</script>";
    }
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql2 = $con->query("UPDATE proveedores SET nombre_prov='".$_POST['nom']."',telefono='".$_POST['tel']."',email='".$_POST['email']."',direccion='".$_POST['dir']."' WHERE nombre_prov='".$_POST['buscar_prov']."'");	
	echo"<script>alert('Se ha Cambiado con Éxito');
 document.location.href='proveedores.php'</script>";
}

/* ELIMINAR CLIENTE */


if(isset($_POST["btneliminar"])) {
	
$sql3= $con->query("DELETE FROM proveedores WHERE nombre_prov='".$_POST['nom']."'");
echo"<script>alert('Se ha Eliminado con Éxito');
 document.location.href='proveedores.php'</script>";

}

// eliminar producto del detalle
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM proveedores WHERE nombre_prov='". $_GET['eliminar'] ."'");
	
	header('Location: clientesadmin.php');
}



?>


<!doctype html>
<html>
	<head>
		<meta charset='utf-8'>
        
  <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
         <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">
		<title>Proveedores</title>
        
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
			height:540px;
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
			background:#09C;
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
            <div class="titulo"><label class="letratitulo1">Proveedores</label></div>
            
            <div class="tablas">

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">Nombre</th>
				<th class="letratabla">Telefono</th>
                <th class="letratabla">Email</th>
                <th class="letratabla">Dirección</th>
		        <th class="letratabla">Eliminar</th>
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
               <th class="letratabla">Nombre</th>
				<th class="letratabla">Telefono</th>
                <th class="letratabla">Email</th>
                <th class="letratabla">Dirección</th>
		        <th class="letratabla">Eliminar</th>
				
              
            </tr>
        </tfoot>
		<tbody>
        <?php $sql4 = $con->query("SELECT * FROM proveedores");
		while($detalle= $sql4->fetch_array()){
			
		
		
		
			echo"<tr>
			
				<td class='letratabla'><center>".$detalle['nombre_prov']."</center></td>
                <td class='letratabla2'><center>".$detalle['telefono']."</center></td>
				<td class='letratabla'><center>".$detalle['email']."</center></td>
				<td class='letratabla2'><center>".$detalle['direccion']."</center></td>
				
               <td class='letratabla'><a href='clientesadmin.php?eliminar=".$detalle['nombre_prov']."'><center><img src='img/basurero.jpg'></center></a></td>
                
            </tr>";
			
            }?>
            </tbody>
    </table>

</div>
            
            
            <div class="formuclientes">
           
            <form action="" method="post" name="formuproducto">
           
            
            <table>
            <tr>
            <td colspan="2"> <label class="letraprod">Proveedor :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Buscar :</label></td> <td><input type="text" id="buscar_prov" name="buscar_prov" class="cajatexto" placeholder="Busqueda por Nombre" ></td>
            </tr>
             <tr>
            <td><label class="letraprod" >Nombre :</label></td> <td><input type="text" id="nom" name="nom" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Telefono</label></td> <td><input type="number" id="tel" name="tel" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">E-mail</label></td> <td><input type="text" name="email" id="email"  class="cajatexto" required ></td>
            </tr>
            <tr>
            <td><label class="letraprod">Dirección</label></td> <td><input type="text" name="dir" id="dir"  class="cajatexto" required></td>
            </tr>
           
           
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod"><input type="submit" name="btneditar" value="Editar" class="botonprod"><input type="submit" name="btneliminar" value="Eliminar" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
         
            
            </div>
            
            </div>

		

		
		</div><!--/con-princ-->
 <div class="titulo"><label class="letratitulo1">Proveedores</label></div>
		<?php
		$con->close();
		?>

		

		<script type="text/javascript">
		$(document).ready(function()
		{
		
			$('#buscar_prov').keyup(function()
			{
				$.ajax({
					url: 'info_proveedor.php',
					type: 'post',
					data: {buscar_prov:$('#buscar_prov').val()},
					dataType:'json',
					success: function(proveedor)
					{
						if ( proveedor ) // Encontro el producto?
						{
							
							$('#nom').val(proveedor.nombre_prov);
							$('#tel').val(proveedor.telefono);
							$('#email').val(proveedor.email);
							$('#dir').val(proveedor.direccion);
						
							
						}
						else // Producto no existe
						{
							
							$('#nom').val('');
							$('#tel').val('');
							$('#email').val('');
							$('#dir').val('');
						
							
							
						}
					}
				});
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

