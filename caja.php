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
        <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css" />
<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="datatable/jquery.dataTables.min.js"></script>
		<title>ProxVentas</title>
        
       
        
        <style> 
        
        #detalle{
			font:Arial, Helvetica, sans-serif;
			font-size:18px;	
		}
		
	.txt-amarillo
	{
		background: yellow;
	}

	.txt-rojo
	{
		background-color: red;
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
			<div id="cabecera">
				<div id="cab-a">
					<?php
					$sql = $con->query("SELECT MAX( Id_Nota_Venta ) AS  `ID_VEN` FROM mnotae");
					$resul = $sql->fetch_array();
					$codvent=$resul["ID_VEN"];
					$codvent= $codvent + 1;

					

					
					if ( isset($_POST["btningresar"]) ) //INGRESAR PRODUCTO
					{
						
						$sql2 = $con->query("SELECT * FROM PRODUCTOS WHERE Codigo_Producto = $_POST[codproducto]");
						if($sql2->num_rows==0){
							echo"<script>alert('El Código $_POST[codproducto] no se encuentra');
							document.location.href='caja.php'</script>";
						exit;}
						$resul2 = $sql2->fetch_array();
						$codpro=$resul2["Codigo_Producto"];
						$des=$resul2["Descripcion"];
						$pordesc=$resul2["Porcentaje_Descuento"];
						$descu=$resul2["Descuento"];
						$precio=$resul2["Precio"];
						$canti=$_POST["cant"];	
						$st=$resul2["Stock"];
						$totalst= $st - $canti;
						if($totalst<0){
							echo"<script>alert('No Dispones de Stock Sufuciente de $des')</script>";
							$totalventa=0;
						}else{
						$precio_c_desc=$precio-$descu;	
						$subtotal=$precio_c_desc*$canti;
						$sql3=$con->query("INSERT INTO mnotad (Id_Nota_Venta,Codigo_Producto,Cantidad_Producto,Precio_Unitario_Venta,Porcentaje_Descuento,Monto_Descuento,Subtotal) VALUES ('$codvent','$codpro','$canti','$precio','$pordesc','$descu','$subtotal')");
						 $con->query("UPDATE productos SET Stock='".$totalst."' WHERE Codigo_Producto='".$codpro."' ");//ACTUALIZA EL STOCK ACTUAL
						$sql6=$con->query("SELECT * FROM mnotad WHERE Id_Nota_Venta = $codvent");
						//$totalventa=0;
						while($resul4=$sql6->fetch_array())
						          {
							//$totalven= $resul4["Precio_Unitario_Venta"] * $resul4["Cantidad_Producto"];
							
							 //$totalventa = $totalventa + $resul4["Subtotal"];
					
								  }
						     }
						/*echo"<script type='text/javascript'>cambiar()</script>";   AQUI QUERIA MANDAR LA FUNCION PARA K SE CAMBIE EL TOTAL DE LA VENTA ACTUAL :( */ 
					}
					else if(isset($_POST["btnvender"])) //VENDER Y GENERAR NOTA DE VENTA
					{
						$efec=@$_POST["efectivo"];
						$vuelto=@$_POST["vuelto"]; 
						$tipov=$_POST["tipoventa"];
						$totalventa=@$_POST["totalfinal"];
						$sql5=$con->query("INSERT INTO mnotae (Id_Nota_Venta,Fecha_Nota_Venta,Tipo_Venta,Vendedor,Codigo_Despacho,Total_Venta,Efectivo,Vuelto) VALUES ('$codvent',CURDATE(),'$tipov','$vendedor','0','$totalventa','$efec','$vuelto')");

						
						
						$sql8=$con->query("SELECT * FROM mnotad WHERE Id_Nota_Venta = $codvent");
						
						while($resul5=$sql8->fetch_array())
						{
							$idprod= $resul5["Codigo_Producto"];
							$cantidad= $resul5["Cantidad_Producto"];
							
							
							
						}
						
						
						header("Location: notaventa.php?codigo_venta=$codvent&totalve=$totalventa&vendedor=$vendedor&ef=$efec&vue=$vuelto");
					}
					else if ( isset($_GET['eliminar']) ) // eliminar producto del detalle
{
	$totalv= $_GET["tot"];
	$canprod = $_GET["canti"];
	$codp= $_GET["cod"];
	
	$sql9=$con->query("SELECT Stock FROM productos WHERE Codigo_Producto='$codp'");
							while($resul6=$sql9->fetch_array())
							{
							$stock= $resul6["Stock"];
							$st_actual= $stock + $canprod;
							
	 $con->query("UPDATE productos SET Stock='".$st_actual."' WHERE Codigo_Producto='".$codp."' ");//DEVUELVE EL STOCK DEL PRODUCTO ELIMINADO
							}
	
	echo("<script>console.log('$totalv')</script>");
	$con->query("DELETE FROM mnotad WHERE id_nota_detalle='". $_GET['eliminar'] ."'");
	$sql7= $con->query("SELECT Subtotal FROM mnotad WHERE id_nota_detalle='". $_GET['eliminar'] ."'");
	$resul7 = $sql7->fetch_array();
	$subt_eliminado= $resul7["Subtotal"];
	$totalv = $totalv - $subt_eliminado;
	//$totalv = $totalventa - $subt_eliminado; 
	
	
	header("Location: caja.php?totalventa=$totalv");
}else
					{
						$totalventa=0;
					}
					?>

					<form name="form1" action="caja.php" method="post">
						<table>
							<tr>
								<td><label class="letracabecera">Cod.Venta :</label></td><td><input type="text" class="cajat-prod" name="codventa" disabled value="<?php echo"$codvent"?>"></td>
                                <td><label class="letracabecera">Descripción :</label></td><td><input type="text" class="cajat-prod" id="descripcion"></td>
                                <td><input type="submit" class="css-button" value="Ingresar" name="btningresar"></td>
							</tr>
							<tr>
								<td><label class="letracabecera">Cod.Producto :</label></td><td><input type="number" class="cajat-prod" id="codigo_producto" name="codproducto" autofocus required ></td>
								<td><label class="letracabecera">Cantidad :</label></td><td><input type="number" class="cajat-cant" name="cant" value="1" min="1" required> </td>
                                
                                
								
							</tr>
							
						</table>
					</form>
				</div>
			</div>

			<div id="detalle">
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
                <th class="letratabla">Eliminar</th>
                
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
                <th class="letratabla">Eliminar</th>
				
              
            </tr>
        </tfoot>
		<tbody>';
		$totalventa=0;
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
				<td class="letratabla2"><center>'.$detalle['subtotal'].'</center></td>';
				
				$totalventa = $totalventa + $detalle['subtotal'];
			 echo' <td><a href="caja.php?eliminar='.$detalle['id_nota_detalle'].'&canti='.$detalle
			   ['cantidad_producto'].'&cod='.$detalle['codigo_producto'].'&tot=$tv"><center><img src="img/btneliminar.png"></center></a></td>
                
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
	}else{
		echo"no hay productos agregados";
		
	    }
	
	
           
           ?>
            
            </div>

			<div id="footer">
				<div id="foo-a">
                <table>
				<tr><td><label class="letracabecera">Precio :</label><input type="text" class="cajat-prec" name="preciounidad" id="preciounidad"></td><td>
					<label class="letracabecera">% Descuento :</label><input type="text" class="cajat-prec" name="desc" id="desc"></td>
                    </tr>
                    </table>
                 	
				</div>

				<div id="foo-b">
					
					   <form action="caja.php" method="post" name="formvender" class="formestilo">  
			<label class="letracabecera">Stock :</label><input type="number" class="cajat-cant" name="stock" id="stock"   required readonly>	

					
                    <label class="letracabecera">Medio Pago :</label>
						<select name="tipoventa" class="selec">
							<option value="Efectivo">Efectivo</option>
							<option value="Debito">Debito</option>
						</select>
						<input type="submit" class="css-button" value="Vender" name="btnvender">
                        <a href="despacho.php?codigo_venta=<?=$codvent?>&totalve=<?=$totalventa?>"><input type="button" class="css-button" value="Despacho" name="boton3"></a>
                        
					
				</div>


				<div id="foo-total">
                
					<label class="letracabecera">TOTAL</label><input type="text"  class="cajat-total" name="totalfinal" id="totalpagar" value="<?php echo $totalventa?>"  readonly >
                    
				</div>
		</div>

			<div id="final">
            
            
				<label class="letracabecera">EFECTIVO</label><input type="number"  class="cajat-total" name="efectivo" id="efectivo" min="0" required>
				<label class="letracabecera">VUELTO</label><input type="number"  class="cajat-total" name="vuelto" id="vuelto" readonly>
                
			</div></form>
		</div><!--/con-princ-->

		<?php
		$con->close();
		?>

	

		<script type="text/javascript">
		$(document).ready(function()
		{
			
			
			$('#example').dataTable( {
        "scrollY":        "340px",
        "scrollCollapse": true,
        "paging":         false,
		 "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "No se Encontraron Registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No Hay Registros en la Tabla",
            "infoFiltered": "(Filtrado desde _MAX_ Registros en Total)",
			"search": "Buscar"
        }
    } );
			


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
							$('#preciounidad').val(producto.precio);
							$('#desc').val(producto.porcentaje_descuento);
							$('#stock').val(producto.stock);
							
							if ( $('#stock').val()>=0 && $('#stock').val()<=10 )
					{
						$('#stock').addClass('txt-rojo');
					}
					if ( $('#stock').val()>=11 && $('#stock').val()<=20 )
					{
						$('#stock').addClass('txt-amarillo');
					}
					
							
						}
						else // Producto no existe
						{
							$('#descripcion').val('');
							$('#preciounidad').val('');
							$('#desc').val('');
							$('#stock').val('');
							$('#stock').removeClass('txt-rojo txt-amarillo');
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
		
		
		function cambiar() 
		{	
		$('#totalpagar').val('666');			
		//document.all("totalfinal").value="666";	
		}
		
		
		</script>

	</body>
</html>