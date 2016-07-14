<?php // content="text/plain; charset=utf-8"

include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);
 


require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');


if(!isset($_GET["an"]))exit;
$an=$_GET["an"];



$sql1= $con->query("SELECT SUBSTRING(Fecha_Nota_Venta,6,2) AS mes,Total_Venta FROM mnotae WHERE SUBSTRING(Fecha_Nota_Venta,1,4)='$an'");
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
	while($res1= $sql1->fetch_array()){
	
	if($res1["mes"]=='01'){
		$ene= $ene + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='02'){
		$feb= $feb + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='03'){
		$mar= $mar + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='04'){
		$abr= $abr + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='05'){
		$may= $may + $res1["Total_Venta"];	
	}
		
	if($res1["mes"]=='06'){
		$jun= $jun + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='07'){
		$jul= $jul + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='08'){
		$ago= $ago + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='09'){
		$sep= $sep + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='10'){
		$oct= $oct + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='11'){
		$nov= $nov + $res1["Total_Venta"];	
	}
	
	if($res1["mes"]=='12'){
		$dic= $dic + $res1["Total_Venta"];	
	}
	
	
		
	}
	
$datay1 = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$datay2 = array($ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);




//SELECT  Fecha_Nota_Venta FROM `mnotae` WHERE SUBSTRING(Fecha_Nota_Venta,5,2)='06'

//$datay1 = array(20,7,16,46);
//$datay2 = array(6,20,10,22);

// Setup the graph
$graph = new Graph(2650,730);
$graph->SetScale("textlin");

$theme_class= new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->title->Set('VENTAS POR AÑO');
$graph->SetBox(false);

//$graph->yaxis->title->set("Pesos");
//$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xaxis->SetTickLabels($datay1);
$graph->ygrid->SetFill(false);
//$graph->SetBackgroundImage("logo.png",BGIMG_FILLFRAME);

$p1 = new LinePlot($datay1);
$graph->Add($p1);

$p2 = new LinePlot($datay2);
$graph->Add($p2);

$p1->SetColor("#55bbdd");
$p1->SetLegend('INGRESOS');
$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$p1->mark->SetColor('#09C');
$p1->mark->SetFillColor('#09C');
$p1->SetCenter();

$p2->SetColor("#09C");
//$p2->SetLegend('Line 22');
$p2->mark->SetType(MARK_UTRIANGLE,'',1.0);
$p2->mark->SetColor('#09C');
$p2->mark->SetFillColor('#09C');
$p2->value->SetMargin(24);
$p2->SetCenter();

$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#09C','#09C');
$graph->legend->SetMarkAbsSize(18);


// Output line
$graph->Stroke();

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
</body>
</html>