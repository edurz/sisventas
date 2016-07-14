<?php // content="text/plain; charset=utf-8"

include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');

if(!isset($_POST["año"]))exit;
$año=$_POST["año"];


$sql= $con->query("SELECT Tipo_Venta, Total_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,4)='$año'");
$efec=0;
$deb=0;
while($res=$sql->fetch_array()){
	
	
	if($res["Tipo_Venta"]=='Efectivo'){
		
		$efec = $efec + $res["Total_Venta"];
	}
	
	if($res["Tipo_Venta"]=='Debito'){
		
		$deb = $deb + $res["Total_Venta"];
	}
	
	
}


$datay=array($efec,$deb);


// Create the graph. These two calls are always required
$graph = new Graph(900,900,'auto');
$graph->SetScale("textlin");

$graph->xaxis->title->Set("Tipo Venta");

//$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// set major and minor tick positions manually
//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');


$graph->xaxis->SetTickLabels(array('EFECTIVO','DEBITO'));
//$graph->yaxis->HideLine(false);
//$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);


$b1plot->SetColor("white");
$b1plot->SetFillGradient("#09C","white",GRAD_LEFT_REFLECTION);
$b1plot->SetWidth(105);
$graph->title->Set("VENTAS POR EFECTIVO Y DEBITO");
//$graph->yaxis->title->Set("Ventas");

// Display the graph
$graph->Stroke();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Grafico Ventas/debito</title>
</head>

<body>
</body>
</html>