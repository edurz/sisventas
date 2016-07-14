<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);


 if(isset($_POST["btntipo"])){
	 $sql2 = $con->query("SELECT tipo_producto FROM categoria_producto WHERE tipo_producto = '".$_POST['categoria']."'");
	 if($sql2->num_rows >0){
		 echo"<script>alert('Esta Categoria Está Ingresada')</script>";
	 }else{
	
	$sql = $con->query("INSERT INTO categoria_producto(tipo_producto) VALUES('".$_POST['categoria']."')");
	     }
}



// eliminar producto del detalle
if ( isset($_GET['eliminar']) )
{
	$con->query("DELETE FROM categoria_producto WHERE id_categoria='". $_GET['eliminar'] ."'");
	
	header('Location: tipo_producto.php');
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
        
		<title>Categoria Productos</title>
        
        <style>
		.producto{
			height:60px;
			width:660px;
			background-color:#fff;
			margin:0 auto;
			padding-top:10px;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
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
		.botonvolver{
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
			   

			<div id="detalle">
            <div class="titulo"><a href="productos.php"><img class="botonvolver" src="img/volver.png"></a><label class="letratitulo1">Categorias de Productos</label></div>
            <div class="producto">
            
           <table>
           
           <form action="tipo_producto.php" name="formutipo" method="post">
            <tr>
            <td><label class="letraprod" >Categoria :</label></td> <td><input type="text" name="categoria" class="cajatexto"></td><td><input type="submit" name="btntipo" value="Ingresar" class="botonprod"></td>
            </tr>
           </form>
            </table>
             
            
            
            
            
            </div>
            
            
            <?php $sqlcategoria = $con->query("SELECT * FROM categoria_producto");
			
			
				echo' <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="letratabla">Codigo Categoria</th>
				<th class="letratabla">Categoria</th>
				<th class="letratabla">Eliminar</th>
               
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th class="letratabla">Codigo Categoria</th>
				<th class="letratabla">Categoria</th>
				<th class="letratabla">Eliminar</th>
               
				
              
            </tr>
        </tfoot>
		<tbody>';
		
			while($categorias = $sqlcategoria->fetch_array()){
				
				echo'<tr>
                <td class="letratabla"><center>'.$categorias['id_categoria'].'</center></td>
				<td class="letratabla2"><center>'.$categorias['tipo_producto'].'</center></td>
               
               <td><a href="tipo_producto.php?eliminar='.$categorias['id_categoria'].'"><center><img src="img/basurero.jpg"></center></a></td>
                
            </tr>';
		}
			
		 echo'</tbody>
    </table>';
			
			
			 ?>
            </div>

		         <div class="titulo"><label class="letratitulo1">Categorias de Productos</label></div>

		
		</div><!--/con-princ-->

		<?php
		$con->close();
		?>

		

		<script type="text/javascript">
		
		$(document).ready(function() {
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
} );
		</script>

	</body>
</html>