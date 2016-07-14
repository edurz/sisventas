<!doctype html>
<html>
	<head>
		<meta charset='utf-8'>
<script>
	function cerrar(){
		
		alert("Sesión Cerrada");
		window.location = "login.php";
		
		
	}
	
	</script>
    
    
    </head>
<body>

<?php

if(isset($_COOKIE["usuario_nombre"])){
setcookie("usuario_nombre","",time() - 60*60*24);
echo "<script>cerrar()</script>";
}else{
	echo "No ha iniciado sesion";}

/*
session_start();

if(isset($_SESSION["usuario"])){

unset($_SESSION["usuario"]);


echo "<script>cerrar()</script>";


	
}
*/

?>


</body>

</html>