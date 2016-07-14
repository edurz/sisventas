<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);


?>


<!doctype html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
   		<link rel="stylesheet" href="css/styles.css">
		<title>CSS MenuMaker</title>
        
        <style>
		.producto{
			height:450px;
			width:660px;
			background-color:#CCC;
			margin:0 auto;
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
		
		
		</style>
	</head>

	<body onLoad="document.form1.codproducto.focus()">

           <?php if(isset($_COOKIE["usuario_nombre"])){
	 $usuario = unserialize($_COOKIE['usuario_nombre']);
	
	
echo "Bienvenido : " . $usuario['nombre'] .
"

<a href='logout.php'>Cerrar Sesion </a>";}
?>

		

		<div id="con-princ">
		

			
            <div class="producto">
            <center><h1 class="letratitulo1">Despacho</h1></center>
            <form action="" method="post" name="formuproducto">
            <table>
            <tr>
            <td><label class="letraprod">Buscar :</label></td><td><input type="text" class="cajatexto"></td><td><input type="submit" value="Buscar" class="botonprod"></td>
            </tr>
             </table>
            <table>
            <tr>
            <td colspan="2"> <label class="letratitulo2">Venta Asociada :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >N° Despacho :</label></td> <td><input type="number" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod" >N° Venta :</label></td> <td><input type="number" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Total venta :</label></td> <td><input type="number" class="cajatexto" required></td>
            </tr>
            <tr>
            <td colspan="2"> <label class="letratitulo2">Despacho :</label></td>
            </tr>
            <tr>
            <td><label class="letraprod" >RUT Cliente :</label></td> <td><input type="number" class="cajatexto" required></td><td><input type="button" value="Nuevo" class="botonprod"></td>
            </tr>
            <tr>
            <td><label class="letraprod" >Nombre :</label></td> <td><input type="text" class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Apellido Paterno:</label></td> <td><input type="text"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Apellido Materno :</label></td> <td><input type="text"  class="cajatexto"></td>
            </tr>
            <tr>
            <td><label class="letraprod">Telefono  :</label></td> <td><input type="number"  class="cajatexto" maxlength="12" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Direccion :</label></td> <td><input type="text"  class="cajatexto" required></td>
            </tr>
            <tr>
            <td><label class="letraprod">Numeracion :</label></td> <td><input type="number"  class="cajatexto" required></td>
            </tr>
             <tr>
            <td><label class="letraprod">Comuna :</label></td> <td><input type="text"  class="cajatexto" required></td>
            </tr>
           
            <tr>
            <td></td> <td><input type="submit" name="btningresar" value="Ingresar" class="botonprod"></td>
            </tr>
            </table>
            </form>
            
            </div>
          

		

		
		</div><!--/con-princ-->

		<?php
		$con->close();
		?>

		<script src="js/jquery-1.8.2.js" type="text/javascript"></script>

		<script type="text/javascript">
		$(document).ready(function()
		{
			// cargar detalle
			$.ajax({
				url: 'detalle.php?codigo_venta=<?=$codvent?>',
				success: function(detalle)
				{
					$('#detalle').html(detalle);
				}
			})

			// Sacar informacion de producto
			$('#codigo_producto').keyup(function()
			{
				$.ajax({
					url: 'info_producto.php',
					type: 'post',
					data: {codigo_producto:$('#codigo_producto').val()},
					dataType:'json',
					success: function(producto)
					{
						if ( producto ) // Encontro el producto?
						{
							$('#descripcion').val(producto.descripcion);
							$('#preciounidad').val(producto.precio_c_iva);
							$('#desc').val(producto.porcentaje_descuento);
						}
						else // Producto no existe
						{
							$('#descripcion').val('');
							$('#preciounidad').val('');
							$('#desc').val('');
							
						}
					}
				});
			});

			$("#efectivo").keyup(function()
			{
				var resul= parseInt($("#efectivo").val()) - parseInt($("#totalpagar").val());
			
				$("#vuelto").val(resul);
			});
		});
		</script>

	</body>
</html>