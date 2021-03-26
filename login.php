<?php
session_start();
require_once 'dbconfig.php';

/* @var $_POST type */
$nombre= $_POST["user"];
$pass= $_POST["password"];
/*La busqueda en la base de datos se realiza de este modo para evitar las inyecciones sql*/
$stmt = $DB_con->prepare('SELECT user, password , departamento FROM login ');
$stmt->execute();
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
	if($nombre == $row['user'] && $pass == $row['password']){
		//echo "Usuario encontrado ";
		$_SESSION['logged'] = true;
		$_SESSION['username'] = $nombre;
		$_SESSION['rol'] = $row['departamento'];
		echo "Bienvenido a la plataforma estimad@: " . $nombre;
		if($_SESSION['rol']=="Publicaciones"){
			header("Location:users_publicaciones.php");
		}
		header("Location:users.php");	
		break;	
	}else{
		echo "Lo sentimos usuario no encontrado, debes revisa e intentalo nuevamente. ";
		header("refresh:5;index.html");
	}
}

?>