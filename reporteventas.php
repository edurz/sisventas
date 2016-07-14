<?php // content="text/plain; charset=utf-8"

include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);
 





if(!isset($_POST["año"]))exit;
$año=$_POST["año"];

?>



<!doctype html>
<html>
<head>
   <script src="datatable/jquery-1.11.1.min.js" type="text/javascript"></script>
         <script src="datatable/jquery-ui.js" type="text/javascript"></script>
        <script src="datatable/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.css" />
   		<link rel="stylesheet" href="css/styles.css">
<meta charset="utf-8">
<title>Reporte de Ventas</title>

<style>
#resultados{
	float:left;	
}

#grafico{
	float:right;
	
}
#contenido{
	margin-top:40px;
	height:800px;
	width:auto;
}

.botonprod{
			height:35px;
			width:100px;
			color:#09C;
			font-family:Arial, Helvetica, sans-serif;
			font-size:18px;
		}
.stylotabla{
	font-family:Arial, Helvetica, sans-serif;
	font-size:35px;
	color:#09F;	
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
<div class="titulo"><label class="letratitulo1">Reporte de Ventas Mensuales Año : <?=$año?></label></div>
<div id="contenido">



<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class='letratabla'>Mes</th>
				<th class='letratabla'>Ventas Efectuadas</th>
                <th class='letratabla'>Costos</th>
                <th class='letratabla'>Ingresos</th>
                <th class='letratabla'>Ganancias</th>
                <th class='letratabla'>Detalle</th>
                
            
                
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th class='letratabla'>Mes</th>
				<th class='letratabla'>Ventas Efectuadas</th>
                <th class='letratabla'>Costos</th>
                <th class='letratabla'>Ingresos</th>
                <th class='letratabla'>Ganancias</th>
                <th class='letratabla'>Detalle</th>
               
				
              
            </tr>
        </tfoot>
		<tbody>
        
        



        <?php $sql1= $con->query("SELECT SUBSTRING(Fecha_Nota_Venta,6,2) AS mes,Total_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,4)='$año'");
	$conene=0;
	$confeb=0;
	$conmar=0;
	$conabr=0;
	$conmay=0;
	$conjun=0;
	$conjul=0;
	$conago=0;
	$consep=0;
	$conoct=0;
	$connov=0;
	$condic=0;
	$ene=0;
	$feb=0;
	$mar=0;
	$abr=0;
	$may=0;
	$jun=0;
	$jul=0;
	$ago=0;
	$sep=0;
	$oct=0;
	$nov=0;
	$dic=0;
	$contcostoene = 0;
	$contcostofeb = 0;
	$contcostomar = 0;
	$contcostoabr = 0;
	$contcostomay = 0;
	$contcostojun = 0;
	$contcostojul = 0;
	$contcostoago = 0;
	$contcostosep = 0;
	$contcostooct = 0;
	$contcostonov = 0;
	$contcostodic = 0;
	
	while($res1= $sql1->fetch_array()){
	
	if($res1["mes"]=='01'){
		$conene= $conene +1;
		$ene= $ene + $res1["Total_Venta"];
		
			
	}
	
	if($res1["mes"]=='02'){
		$confeb= $confeb +1;
		$feb= $feb + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='03'){
		$conmar= $conmar +1;
		$mar= $mar + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='04'){
		$conabr= $conabr +1;
		$abr= $abr + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='05'){
		$conmay= $conmay +1;
		$may= $may + $res1["Total_Venta"];	
		
	}
		
	if($res1["mes"]=='06'){
		$conjun= $conjun +1;
		$jun= $jun + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='07'){
		$conjul= $conjul +1;
		$jul= $jul + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='08'){
		$conago=$conago +1;
		$ago= $ago + $res1["Total_Venta"];
		
	}
	
	if($res1["mes"]=='09'){
		$consep= $consep +1;
		$sep= $sep + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='10'){
		$conoct= $conoct +1;
		$oct= $oct + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='11'){
		$connov= $connov +1;
		$nov= $nov + $res1["Total_Venta"];	
		
	}
	
	if($res1["mes"]=='12'){
		$condic= $condic +1;
		$dic= $dic + $res1["Total_Venta"];	
		
	}
	
	
		}
	
//CONTADOR DE COSTOS POR MES  _______________________________________________________________ 
$eneyaño= $año . "-01";
$febyaño= $año . "-02";
$maryaño= $año . "-03";
$abryaño= $año . "-04";
$mayyaño= $año . "-05";
$junyaño= $año . "-06";
$julyaño= $año . "-07";
$agoyaño= $año . "-08";	
$sepyaño= $año . "-09";
$octyaño= $año . "-10";
$novyaño= $año . "-11";
$dicyaño= $año . "-12";
//ENERO
	$sql2= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$eneyaño'");
while($idventa= $sql2->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql3= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql3->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql4= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql4->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostoene= $contcostoene + $totalcosto;
	 }
}	
//FEBRERO
		$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$febyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostofeb= $contcostofeb + $totalcosto;
	 }
}	
//MARZO
	$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$maryaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostomar= $contcostomar + $totalcosto;
	 }
}

//ABRIL
	$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$abryaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostoabr= $contcostoabr + $totalcosto;
	 }
}

//MAYO

	$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$mayyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		$sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostomay= $contcostomay + $totalcosto;
	 }
}

//JUNIO
	$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$junyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostojun= $contcostojun + $totalcosto;
	 }
}
//JULIO
	$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$julyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostojul= $contcostojul + $totalcosto;
	 }
}
//AGOSTO
$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$agoyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostoago= $contcostoago + $totalcosto;
	 }
}

//SEPTIEMBRE
$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$sepyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostosep= $contcostosep + $totalcosto;
	 }
}

//OCTUBRE
$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$octyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		$sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostooct= $contcostooct + $totalcosto;
	 }
}

//NOVIEMBRE
$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$novyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		 $sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostonov= $contcostonov + $totalcosto;
	 }
}

//DICIEMBRE
$sql5= $con->query("SELECT Id_Nota_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,7) = '$dicyaño'");
while($idventa= $sql5->fetch_array())
{
$idv= $idventa["Id_Nota_Venta"];	
$sql6= $con->query("SELECT Codigo_Producto, Cantidad_Producto FROM mnotad WHERE Id_Nota_Venta= $idv");
while($idprod= $sql6->fetch_array())
     {
		 
		 $idp= $idprod["Codigo_Producto"];
		 $cantprod= $idprod["Cantidad_Producto"];
		$sql7= $con->query("SELECT Costo FROM productos WHERE Codigo_Producto= $idp");
		 $costoprod= $sql7->fetch_array();
		 $cpd= $costoprod["Costo"];
		 $totalcosto= $cpd * $cantprod;
		 
		 $contcostodic= $contcostodic + $totalcosto;
	 }
}
	
			echo"<tr>
			
				<td class='letratabla'><center>01. Enero</center></td>
				<td class='letratabla'><center>".$conene."</center></td>
				<td class='letratabla'><center>".$contcostoene."</center></td>
				<td class='letratabla'><center>".$ene."</center></td>
				<td class='letratabla'><center>".($ene -$contcostoene)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$eneyaño'><img src='img/detalleventas.png'></a></center></td>
				
				
				</tr>
				<tr>
			
				<td class='letratabla2'><center>02. Febrero</center></td>
				<td class='letratabla2'><center>".$confeb."</center></td>
				<td class='letratabla2'><center>".$contcostofeb."</center></td>
                <td class='letratabla2'><center>".$feb."</center></td>
				<td class='letratabla2'><center>".($feb -$contcostofeb)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$febyaño'><img src='img/detalleventas.png'></center></td>
				
				</tr>
				<tr>
		        <td class='letratabla'><center>03. Marzo</center></td>
				<td class='letratabla'><center>".$conmar."</center></td>
				<td class='letratabla'><center>".$contcostomar."</center></td>
				<td class='letratabla'><center>".$mar."</center></td>
				<td class='letratabla'><center>".($mar -$contcostomar)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$maryaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
		        <td class='letratabla2'><center>04. Abril</center></td>
				<td class='letratabla2'><center>".$conabr."</center></td>
				<td class='letratabla2'><center>".$contcostoabr."</center></td>
				<td class='letratabla2'><center>".$abr."</center></td>
				<td class='letratabla2'><center>".($abr -$contcostoabr)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$abryaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
			
				<td class='letratabla'><center>05. Mayo</center></td>
				<td class='letratabla'><center>".$conmay."</center></td>
				<td class='letratabla'><center>".$contcostomay."</center></td>
				<td class='letratabla'><center>".$may."</center></td>
				<td class='letratabla'><center>".($may -$contcostomay)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$mayyaño'><img src='img/detalleventas.png'></center></td>
				
				</tr>
				<tr>
			
				<td class='letratabla2'><center>06. Junio</center></td>
				<td class='letratabla2'><center>".$conjun."</center></td>
				<td class='letratabla2'><center>".$contcostojun."</center></td>
                <td class='letratabla2'><center>".$jun."</center></td>
				<td class='letratabla2'><center>".($jun -$contcostojun)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$junyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
		        <td class='letratabla'><center>07. Julio</center></td>
				<td class='letratabla'><center>".$conjul."</center></td>
				<td class='letratabla'><center>".$contcostojul."</center></td>
				<td class='letratabla'><center>".$jul."</center></td>
				<td class='letratabla'><center>".($jul -$contcostojul)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$julyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
		        <td class='letratabla2'><center>08. Agosto</center></td>
				<td class='letratabla2'><center>".$conago."</center></td>
				<td class='letratabla2'><center>".$contcostoago."</center></td>
				<td class='letratabla2'><center>".$ago."</center></td>
				<td class='letratabla2'><center>".($ago -$contcostoago)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$agoyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
			
				<td class='letratabla'><center>09. Septiembre</center></td>
				<td class='letratabla'><center>".$consep."</center></td>
				<td class='letratabla'><center>".$contcostosep."</center></td>
				<td class='letratabla'><center>".$sep."</center></td>
				<td class='letratabla'><center>".($sep -$contcostosep)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$sepyaño'><img src='img/detalleventas.png'></center></td>
				
				</tr>
				<tr>
			
				<td class='letratabla2'><center>10. Octubre</center></td>
				<td class='letratabla2'><center>".$conoct."</center></td>
				<td class='letratabla2'><center>".$contcostooct."</center></td>
                <td class='letratabla2'><center>".$oct."</center></td>
				<td class='letratabla2'><center>".($oct -$contcostooct)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$octyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
		        <td class='letratabla'><center>11. Noviembre</center></td>
				<td class='letratabla'><center>".$connov."</center></td>
				<td class='letratabla'><center>".$contcostonov."</center></td>
				<td class='letratabla'><center>".$nov."</center></td>
				<td class='letratabla'><center>".($nov -$contcostonov)."</center></td>
				<td class='letratabla'><center><a href='reporteventadetalle.php?detallemes=$novyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				<tr>
		        <td class='letratabla2'><center>12. Diciempre</center></td>
				<td class='letratabla2'><center>".$condic."</center></td>
				<td class='letratabla2'><center>".$contcostodic."</center></td>
				<td class='letratabla2'><center>".$dic."</center></td>
				<td class='letratabla2'><center>".($dic -$contcostodic)."</center></td>
				<td class='letratabla2'><center><a href='reporteventadetalle.php?detallemes=$dicyaño'><img src='img/detalleventas.png'></center></td>
				</tr>
				
				";
			
            ?>
            </tbody>
    </table>
    
    <div id="resultados">
<table>
<tr>
<td class="stylotabla">Total Ingresos :</td><td class="stylotabla">$<?=($ene+$feb+$mar+$abr+$jun+$jul+$ago+$sep+$oct+$nov+$dic)?></td>
</tr>
<tr>
<td class="stylotabla">Total Costos :</td><td class="stylotabla">$<?=($contcostoene+$contcostofeb+$contcostomar+$contcostoabr+$contcostomay+$contcostojun+$contcostojul+$contcostoago+$contcostosep+$contcostooct+$contcostonov+$contcostodic)?></td>
</tr>
<tr>
<td class="stylotabla">Total Ganancias :</td><td class="stylotabla">$<?=($ene -$contcostoene)+($feb -$contcostofeb)+($mar -$contcostomar)+($abr -$contcostoabr)+($may -$contcostomay)+($jun -$contcostojun)+($jul -$contcostojul)+($ago -$contcostoago)+($sep -$contcostosep)+($oct -$contcostooct)+($nov -$contcostonov)+($dic-$contcostodic)?></td>
</tr>
</table>
</div>
<div id="grafico">
<table>
<tr>
<td height="46"><label class="letrauser">Gráfico :</label></td>
</tr>
<tr>
<td><a href="graficoventas.php?an=<?=$año?>"><center><img src='img/grafico.png'></center></a></td>
</tr>
</tr>

</table>

</div>



</div>

<script type="text/javascript">
		$(document).ready(function()
		{
			
			
			
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