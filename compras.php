<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

	$sqlidcompra = $con->query("SELECT MAX( codigo_compra ) AS  `ID_COM` FROM compras");
					$resul = $sqlidcompra->fetch_array();
					$codcompra=$resul["ID_COM"];
					$codcompra= $codcompra + 1;


if ( isset($_GET['eliminar']) )
{
	$sql6= $con->query("SELECT cantidad_com, codigo_producto FROM compras WHERE codigo_compra='". $_GET['eliminar'] ."'");
	$can= $sql6->fetch_array();
	$codpro= $can["codigo_producto"];
	$canti=$can["cantidad_com"];
	$sql7= $con->query("SELECT Stock FROM productos WHERE Codigo_Producto= '$codpro' ");
	$resul2= $sql7->fetch_array();
	$stock= $resul2["Stock"];
	$stnuevo= $stock - $canti;
	$con->query("UPDATE productos SET Stock='$stnuevo' WHERE Codigo_Producto='$codpro'");
	$con->query("DELETE FROM compras WHERE codigo_compra='". $_GET['eliminar'] ."'");
	header("Location: compras.php");
}


/* --------INGRESAR CLIENTE -------------*/
if(isset($_POST["btningresar"]))
{
	
$sql3= $con->query("SELECT codigo_compra FROM compras WHERE codigo_compra ='".$_POST['codcompra']."'");	
$sql5= $con->query("SELECT Codigo_Producto FROM productos WHERE Codigo_Producto ='".$_POST['codprod']."'");	
if($sql3->num_rows > 0){
	echo"<script>alert('Esta Orden de compra ya está Ingresada')</script>";
}elseif($sql5->num_rows == 0){
	echo"<script>alert('El Código de Producto no Existe')</script>";
}else{
$sql = $con->query("INSERT INTO compras(codigo_compra,codigo_producto,nombre_prod,nombre_prov,cantidad_com,costo_un,total_com,fecha) VALUES('".$_POST['codcompra']."','".$_POST['codprod']."','".$_POST['prod']."','".$_POST['cat']."','".$_POST['cant']."','".$_POST['costo']."','".$_POST['total']."',CURDATE())");

$sqlstock = $con->query("UPDATE productos SET Stock= '".$_POST['cant']."' WHERE Codigo_Producto= '".$_POST['codprod']."' ");

echo"<script>alert('Ingresado con Éxito');
 document.location.href='compras.php'</script>";


   }
}

/* --------EDITAR CLIENTE -------------*/
if(isset($_POST["btneditar"])){
	
$sql4 = $con->query("UPDATE compras SET codigo_producto='".$_POST['nom']."',Apellido_Usuario='".$_POST['ape']."',Clave_Acceso='".$_POST['clave']."',Tipo_Usuario='".$_POST['tipouser']."' WHERE rut_Usuario='".$_POST['rut']."'");	
echo"<script>alert('Se ha Editado con Éxito');
 document.location.href='compras.php'</script>";		
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
		<title>Compras</title>
        
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
			<div class="titulo"><label class="letratitulo1">Compras</label></div>

			<div id="detalleprod">
            
           <div class="tablaproductos"> 
            
             <?php $sqlproductos = $con->query("SELECT * FROM compras");
			
			
				echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">Orden Compra</th>
				<th class="letratabla">Cod. Producto</th>
				<th class="letratabla">Producto</th>
				<th class="letratabla">Proveedor</th>
				<th class="letratabla">Cantidad</th>
				<th class="letratabla">Costo Un.</th>
				<th class="letratabla">Total</th>
				<th class="letratabla">Fecha</th>
				<th class="letratabla">Eliminar</th>
           </tr>
		   
        </thead>
 
        <tfoot>
            <tr>
               <th class="letratabla">Orden Compra</th>
				<th class="letratabla">Cod. Producto</th>
				<th class="letratabla">Producto</th>
				<th class="letratabla">Proveedor</th>
				<th class="letratabla">Cantidad</th>
				<th class="letratabla">Costo Un.</th>
				<th class="letratabla">Total</th>
				<th class="letratabla">Fecha</th>
				<th class="letratabla">Eliminar</th>
               
				
              
            </tr>
        </tfoot>
		<tbody>';
		
			while($productos = $sqlproductos->fetch_array()){
				
				echo'<tr>
                <td class="letratabla"><center>'.$productos['codigo_compra'].'</center></td>
				<td class="letratabla2"><center>'.$productos['codigo_producto'].'</center></td>
				<td class="letratabla"><center>'.$productos['nombre_prod'].'</center></td>
				<td class="letratabla2"><center>'.$productos['nombre_prov'].'</center></td>
				<td class="letratabla"><center>'.$productos['cantidad_com'].'</center></td>
				<td class="letratabla2"><center>'.$productos['costo_un'].'</center></td>
				<td class="letratabla"><center>'.$productos['total_com'].'</center></td>
				<td class="letratabla2"><center>'.$productos['fecha'].'</center></td>
               
               <td class="letratabla"><a href="compras.php?eliminar='.$productos['codigo_compra'].'"><center><img src="img/basurero.jpg"></center></a></td>
                
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
            <td colspan="2"> <label class="letraprod">Ingresar Compras</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Cod. Compra 
            </label></td> <td><input type="text" class="cajatexto" name="codcompra" id="codcompra" value="<?=$codcompra?>" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Cod.Producto </label></td> <td><input type="number"  class="cajatexto" name="codprod" id="buscar_producto" required></td><td><a href="productos.php"><input type="button" class="botonprod" value="Productos"></a></td>
            </tr>
            <tr>
            <td><label class="letraprod">Producto </label></td> <td><input type="text"  class="cajatexto" name="prod" id="prod" readonly></td>
            </tr>
            <tr>
            <td><label class="letraprod">Proveedor :</label></td> <td><select name="cat" id="cat"   class="cajatexto"> 
          <?php $sql2 = $con->query("SELECT * FROM proveedores");
		  
		  while($tipos= $sql2->fetch_array()){  ?>
    <option value="<?php echo $tipos['nombre_prov']?>"> <?php echo $tipos['nombre_prov']?>  </option>        
            
            <?php }?> 
            </select>
           </td><td><a href="proveedores.php"><img src="img/useradd.png"></a></td>
            </tr>
          
            <tr>
            <td><label class="letraprod">Cantidad :</label></td> <td><input type="number" min="1" class="cajatexto" name="cant" id="cant" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Costo Un.:</label></td> <td><input type="number"  class="cajatexto" name="costo" id="costo" min="0" required></td>
            </tr>
             <tr>
            <td><label class="letraprod">Total :</label></td> <td><input type="number"  class="cajatexto" name="total" id="total" required></td>
            </tr>
            
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
            </div>
            </div>

		<div class="titulo"><label class="letratitulo1">Compras</label></div>

		
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
							
							$('#prod').val(buscarprod.Descripcion);
							
						}
						else // Producto no existe
						{
							
							$('#prod').val('');
							
							
							
						}
					}
				});
			});

			$("#costo").keyup(function()
			{
				var resul= parseInt($("#cant").val()) * parseInt($("#costo").val());
			
				$("#total").val(resul);
				
				
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