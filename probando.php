

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


<script type="text/javascript">

$(document).ready(function()
		{
		});
	function cambiar(x){
		
	document.all("tex1").value="6666";
		var xx = document.form1.tex1.value;
	var g= document.getElementById("texto");

	g.style.backgroundColor = "green";
	var e = document.getElementById("capa");
	e.style.backgroundColor = "blue";
	alert(xx);
	
	}

</script>

<style>
.txtrojo{
	background-color:#00C;
	font-size:18px;	
}

	#capa{
			width: 200px;
			height: 200px;
			border: 1px solid #000;
			background-color: red;
		}

</style>


</head>




<div id="capa">

</div>
<body>
efsdf
<form action="" name="form1" method="post" >

<input type="text" name="tex" id="texto" />

<input type="text" name="tex1" id="texx1" readonly="readonly"/>

<input type="submit" value="enviar" name="btn" />

</form>


<?php  

if(isset($_POST["btn"])){
	echo"<div id='capa'>asdas</div>";
	$e= $_POST["tex"];
	echo"<script type='text/javascript'>cambiar('$e')</script>";
	
}

?>

</body>
</html>