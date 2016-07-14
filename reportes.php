<?php // content="text/plain; charset=utf-8"

include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);


/* <form action="gra-tipoventas.php" method="post">
<tr>
<td><label class="letra">Ventas según Tipo :</label></td><td><input type="number" class="cajatexto" name="año" placeholder="ingrese año" required></td><td> <input type="submit" class="css-button" value="Ver"></td>
</tr>
</form> */

 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reportes</title>
<link rel="stylesheet" href="css/styles.css">

<style>

#contenido{
	margin-top:40px;
	height:800px;
	width:auto;
	
	
}

.letra{
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
		
		.cajatexto{
			width:350px;
			height:30px;
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
   				<li><a href='clientes.php'><span>Clientes</span></a></li>
				</ul>
				</div>";
				
}
}else{
echo"<script type='text/javascript'>alert('Por Favor Iniciar Sesion'); window.location='login.php'</script>";	
	
}
?>
 <div class="titulo"><label class="letratitulo1">Reportes</label></div>
<center><div id="contenido">
<table>
<form action="reporteventas.php" method="post">
<tr>
<td><label class="letra">Ventas :</label></td><td><input type="number" class="cajatexto" name="año" placeholder="ingrese año" required></td><td> <input type="submit" class="css-button" value="Ver"></td>
</tr>
</form>


</table>

</div></center>
</body>
</html>

