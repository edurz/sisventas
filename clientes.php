<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);



/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"])){
	$sql3= $con->query("SELECT rut_cliente FROM clientes WHERE rut_cliente ='".$_POST['rut']."'");	
if($sql3->num_rows > 0){
	echo"<script>alert('Este Cliente Ya Fue Ingresado')</script>";

}else{
	
$sql = $con->query("INSERT INTO clientes(rut_cliente,nombre_cliente,apellido_paterno,apellido_materno,telefono,direccion,numeracion_dir,comuna) VALUES('".$_POST['rut']."','".$_POST['nom']."','".$_POST['ape1']."','".$_POST['ape2']."','".$_POST['tel']."','".$_POST['dir']."','".$_POST['num']."','".$_POST['comu']."')");
echo"<script>alert('Se ha Ingresado con Éxito');
 document.location.href='clientes.php'</script>";	
    }
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql2 = $con->query("UPDATE clientes SET nombre_cliente='".$_POST['nom']."',apellido_paterno='".$_POST['ape1']."',apellido_materno='".$_POST['ape2']."',telefono='".$_POST['tel']."',direccion='".$_POST['dir']."',numeracion_dir='".$_POST['num']."',comuna='".$_POST['comu']."'WHERE rut_cliente='".$_POST['rut']."'");	
echo"<script>alert('Se ha Editado con Éxito');
 document.location.href='clientes.php'</script>";		
}

/* ELIMINAR CLIENTE */


if(isset($_POST["btneliminar"])) {
	
$sql3= $con->query("DELETE FROM clientes WHERE rut_cliente='".$_POST['rut']."'");
echo"<script>alert('Se ha Eliminado con Éxito');
 document.location.href='clientes.php'</script>";	

}

?>


<!doctype html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
   		<link rel="stylesheet" href="css/styles.css">
		<title>Clientes</title>
        
        <style>
		.producto{
			height:450px;
			width:660px;
			background-color:#fff;
			margin:0 auto;
			padding-top:10px;
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
			 <div class="titulo"><label class="letratitulo1">Clientes</label></div>

			<div id="detalle">
            <div class="producto">
            
            <form action="" method="post" name="formuproducto">
            <table>
            <tr>
            <td><label class="letraprod">Buscar :</label></td><td><input type="text" class="cajatexto" id="buscar_cliente"  name="bsc" placeholder="Busqueda por RUT" autofocus></td>
            </tr>
             </table>
            <table>
            <tr>
            <td colspan="2"> <label class="letraprod">Cliente :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >RUT</label></td> <td><input type="text" id="rut" name="rut" class="cajatexto" placeholder="Ingreso Sin Puntos ni Guión" required></td>
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

		<?php
		$con->close();
		?>

		<script src="js/jquery-1.8.2.js" type="text/javascript"></script>

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

			
		});
		</script>

	</body>
</html>