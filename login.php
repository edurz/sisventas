<?php
include 'base_de_datos.php';

$con = @new mysqli(host, usuario, contrasena, nombre);

if(isset($_COOKIE["usuario_nombre"]))
{
echo "<script>alert('La Sesion ya esta iniciada'); window.location='caja.php'</script>";	
}

if(isset($_POST["login"])){
	

	$sql2= $con->query("select Tipo_Usuario, Nombre_Usuario, Clave_Acceso from usuarios where Nombre_Usuario = '".$_POST["nombre"]."' and Clave_Acceso = '".$_POST["clave"]."' ");
	
	$num = $sql2->num_rows;
	if($num== 0){
	echo "<script>alert('Nombre o Clave Incorrectos')</script>";		
	}



if(!isset($_COOKIE["usuario_nombre"]))
{
	
	$sql= $con->query("select Tipo_Usuario, Nombre_Usuario, Clave_Acceso from usuarios where Nombre_Usuario = '".$_POST["nombre"]."' and Clave_Acceso = '".$_POST["clave"]."' ");
	
	$num = $sql->num_rows;
	if($num== 1){
		
		$fila=$sql->fetch_array();


$datos = array(
				'id' => $fila['Tipo_Usuario'],
				'nombre'=>$fila['Nombre_Usuario']
			  );

	            
setcookie("usuario_nombre",serialize($datos),time() + 60*60*24);
header("location:caja.php");
}		
	
	
}else{
	echo "<script>alert('La Sesion ya esta iniciada'); window.location='caja.php'</script>";	
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/styles.css">
<title>ProxVentas</title>

<style type="text/css">
<!--
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background-color: #42413C;
	margin: 0;
	padding: 0;
	color: #000;
}



a img {
	border: none;
}

a:link {
	color: #42413C;
	text-decoration: underline; /* a no ser que aplique estilos a los vínculos para que tengan un aspecto muy exclusivo, es recomendable proporcionar subrayados para facilitar una identificación visual rápida */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* este grupo de selectores proporcionará a un usuario que navegue mediante el teclado la misma experiencia de hover (paso por encima) que experimenta un usuario que emplea un ratón. */
	text-decoration: none;
}


.contenedor {
	width: auto;
	height:auto;
	background-color: #FFF;
	margin: 0 auto; 
}


.header {
	background-color: #09C;
}



.contlogin {
	margin: 0 auto;
	margin-top:50px;
	margin-bottom:50px;
	height:350px;
	width:500px;
	background-color:#CCC;
	}

.login{
	height:200px;
	width:350px;
	margin:auto;
	margin-top:20px;
	padding-top:100px;
	
	
}

.footer {
	padding: 10px 0;
	background-color: #09C;
}

.caja-login{
	width:200px;
	height:25px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	
}

</style>


</head>

<body>




<div class="contenedor">
  <div class="header"><a href="#"><img src="img/logo.png" alt="Insertar logotipo aquí" name="Insert_logo" width="180" height="90" id="Insert_logo" style="background-color: #C6D580; display:block;"  /></a> 
  <center> <label class="letratitulo1">Bienvenidos </label></center></div>
  <div class="contlogin">
  <div class="login">
    <form action="login.php" method="post" name="formulogin">
    <table>
    <tr>
    <td>Ingresar :</td>
    </tr>
    <tr>
    <td><label>Nombre : </label> </td>   <td><input type="text" class="caja-login" name="nombre" id="" required="required"></td>
    </tr>
    <tr>
       <td><label>Clave : </label> </td>   <td><input type="password" class="caja-login" name="clave" id="" required="required"></td>
    </tr>
    <tr>
    <td></td><td><input type="submit" class="css-button" value="Login" name="login" ></td>
    </tr>
   
   </table>
   </form> 
   
  </div>
  </div>
  <div class="footer">
    <p>ProxVentas</p>
  <!-- end .footer --></div>
</body>
</html>