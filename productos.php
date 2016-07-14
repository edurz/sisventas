<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

//eliminar 
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM Productos WHERE Codigo_Producto='". $_GET['eliminar'] ."'");
	header("Location: Productos.php");
}


/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"]))
{
	
$sql3= $con->query("SELECT Codigo_Producto FROM productos WHERE Codigo_Producto ='".$_POST['cod']."'");	
if($sql3->num_rows > 0){
	echo"<script>alert('Este código ya esta Ingresado')</script>";
}else{
	
$sql = $con->query("INSERT INTO productos(Codigo_Producto,Descripcion,Tipo_Producto,Porcentaje_Descuento,Descuento,Precio,Precio_C_Desc,Costo) VALUES('".$_POST['cod']."','".$_POST['prod']."','".$_POST['cat']."','".$_POST['desc']."','".$_POST['valordesc']."','".$_POST['pre']."','".$_POST['pre-c-desc']."','".$_POST['costoun']."')");
echo"<script>alert('Ingresado con Éxito');
 document.location.href='productos.php'</script>";
   }
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql4 = $con->query("UPDATE productos SET Codigo_Producto='".$_POST['cod']."',Descripcion='".$_POST['prod']."',Tipo_Producto='".$_POST['cat']."',Porcentaje_Descuento='".$_POST['desc']."',Descuento='".$_POST['valordesc']."',Precio='".$_POST['pre']."',Precio_C_Desc='".$_POST['pre-c-desc']."',Costo='".$_POST['costoun']."' WHERE Codigo_Producto='".$_POST['buscar_producto']."'");	
echo"<script>alert('Se ha Editado con Éxito');
 document.location.href='productos.php'</script>";	
}


?>


<!doctype html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
         <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
          <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">
		<title>Productos</title>
        
        <style>
		#detalleprod{
	width:auto;
	background:#FFF;
	height:700px;

}
		
		.producto{
			height:450px;
			width:660px;
			background-color:#FFF;
			margin:10px;
			float:left;
			}
		.producto td{
			height:30px;
			width: 100px;
			
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
		#detalle{
			font:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
		.letrauser{
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
			color:#09C;
		}
		.tablaproductos{
			height:500px;
			width:900px;
			margin:10px;
			float:left;	
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
			<div class="titulo"><label class="letratitulo1">Productos</label></div>

			<div id="detalleprod">
            
           <div class="tablaproductos"> 
            
             <?php $sqlproductos = $con->query("SELECT * FROM productos");
			
			
				echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">Codigo</th>
				<th class="letratabla">Producto</th>
				<th class="letratabla">Categoria</th>
				<th class="letratabla">Descuento</th>
				<th class="letratabla">Valor Desc.</th>
				<th class="letratabla">Precio</th>
				<th class="letratabla">Prec.C/Desc.</th>
				<th class="letratabla">Costo Un.</th>
				<th class="letratabla">Eliminar</th>
           </tr>
		   
        </thead>
 
        <tfoot>
            <tr>
               <th class="letratabla">Codigo</th>
				<th class="letratabla">Producto</th>
				<th class="letratabla">Categoria</th>
				<th class="letratabla">Descuento</th>
				<th class="letratabla">Valor Desc.</th>
				<th class="letratabla">Precio</th>
				<th class="letratabla">Prec.C/Desc.</th>
				<th class="letratabla">Costo Un.</th>
				<th class="letratabla">Eliminar</th>
               
				
              
            </tr>
        </tfoot>
		<tbody>';
		
			while($productos = $sqlproductos->fetch_array()){
				
				echo'<tr>
                <td class="letratabla"><center>'.$productos['Codigo_Producto'].'</center></td>
				<td class="letratabla2"><center>'.$productos['Descripcion'].'</center></td>
				<td class="letratabla"><center>'.$productos['Tipo_Producto'].'</center></td>
				<td class="letratabla2"><center>'.$productos['Porcentaje_Descuento'].'%</center></td>
				<td class="letratabla"><center>'.$productos['Descuento'].'</center></td>
				<td class="letratabla2"><center>'.$productos['Precio'].'</center></td>
				<td class="letratabla"><center>'.$productos['Precio_C_Desc'].'</center></td>
				<td class="letratabla2"><center>'.$productos['Costo'].'</center></td>
               
               <td class="letratabla"><a href="productos.php?eliminar='.$productos['Codigo_Producto'].'"><center><img src="img/basurero.jpg"></center></a></td>
                
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
			
			
			 ?>
            
    </div>
 
            
            <div class="producto">
            <form action="" method="post" name="formuproducto">
            <table>
            <tr>
            <td><label class="letraprod">Buscar :</label></td><td><input type="text" class="cajatexto" id="buscar_producto" name="buscar_producto" placeholder="Busqueda por Código" autofocus></td>
            </tr>
             </table>
            <table>
            <tr>
            <td colspan="2"> <label class="letraprod">Ingresar Productos</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Código :</label></td> <td><input type="text" class="cajatexto" name="cod" id="cod"></td>
            </tr>
            <tr>
            <td><label class="letraprod">Producto :</label></td> <td><input type="text"  class="cajatexto" name="prod" id="prod"></td>
            </tr>
            <tr>
            <td><label class="letraprod">Categoria Producto :</label></td> <td><select name="cat" id="cat"   class="cajatexto"> 
          <?php $sql2 = $con->query("SELECT * FROM categoria_producto");
		  
		  while($tipos= $sql2->fetch_array()){  ?>
    <option value="<?php echo $tipos['tipo_producto']?>"> <?php echo $tipos['tipo_producto']?>  </option>        
            
            <?php }?> 
            </select>
           </td><td><a href="tipo_producto.php"><img src="img/agrega.png"></a></td>
            </tr>
          
            <tr>
            <td><label class="letraprod">Precio :</label></td> <td><input type="number" min="1" class="cajatexto" name="pre" id="pre"></td>
            </tr>
            <tr>
            <td><label class="letraprod">Descuento %:</label></td> <td><input type="number"  class="cajatexto" name="desc" id="desc" min="0" max="100"></td>
            </tr>
             <tr>
            <td><label class="letraprod">Descuento :</label></td> <td><input type="number"  class="cajatexto" name="valordesc" id="valordesc" readonly></td>
            </tr>
             <tr>
            <td><label class="letraprod">Precio C/Desc :</label></td> <td><input type="number"  class="cajatexto" name="pre-c-desc" id="pre-c-desc" readonly></td>
            </tr>
             <tr>
            <td><label class="letraprod">Costo Un.:</label></td> <td><input type="number"  class="cajatexto" name="costoun" id="costoun"></td>
            </tr>
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod">    
              <input type="submit" name="btneditar" value="Editar" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
            </div>
            </div>

		<div class="titulo"><label class="letratitulo1">Productos</label></div>

		
		</div><!--/con-princ-->

		<?php
		$con->close();
		?>

		

		<script type="text/javascript">
		$(document).ready(function()
		{
			

			// Sacar informacion de producto
			$('#buscar_producto').keyup(function()
			{
				$.ajax({
					url: 'buscar_producto.php',
					type: 'post',
					data: {buscar_producto:$('#buscar_producto').val()},
					dataType:'json',
					success: function(buscarprod)
					{
						if ( buscarprod ) // Encontro el producto?
						{
							$('#cod').val(buscarprod.Codigo_Producto);
							$('#prod').val(buscarprod.Descripcion);
							$('#cat').val(buscarprod.Tipo_Producto);
							$('#pre').val(buscarprod.Precio);
							$('#desc').val(buscarprod.Porcentaje_Descuento);
							$('#valordesc').val(buscarprod.Descuento);
							$('#pre-c-desc').val(buscarprod.Precio_C_Desc);
							$('#costoun').val(buscarprod.Costo);
						}
						else // Producto no existe
						{
							$('#cod').val('');
							$('#prod').val('');
							$('#cat').val('');
							$('#stock').val('');
							$('#pre').val('');
							$('#desc').val('');
							$('#valordesc').val('');
							$('#pre-c-desc').val('');
							$('#costoun').val('');
							
							
						}
					}
				});
			});

			$("#desc").keyup(function()
			{
				var resul= parseInt($("#pre").val()) * parseInt($("#desc").val())/ 100;
			var precdesc = parseInt($("#pre").val()) - resul
				$("#valordesc").val(resul);
				$("#pre-c-desc").val(precdesc);
				
			});
			
		
			
			
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
			
		});
		</script>

	</body>
</html>