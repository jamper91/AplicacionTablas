<?php
$connect;
//Lugar donde se encuentra nuestra base de datos
$host="localhost";
//Su nombre de usuario de la base de datos
$user="jumer_tablas";
//Contrasena
$pass="tablas12345";
//Nombre de la base de datos
$db="jumer_aplicacionTablas";
//Su nombre de usuario de la base de datos
$user="root";
//Contrasena
$pass="";
//Nombre de la base de datos
$db="tablas";
	/*Se encarga de conectarnos con Mysql, pero ante cualquier problema nostraremos el mensaje*/
	$connect=mysql_connect($host,$user,$pass)  or die ("La Base de datos está innacesible en estos momentos");
	/*Pero como sabran Mysql puede tener muchas bases de datos, aqui nos escargamos de deciles a cual nos conectaremos*/
	mysql_select_db($db,$connect);
	/*Esta funcion se encargara de devolvernos una conexion a la base de datos */
	function con()
	{
		global $connect;
		
		return $connect;
	}
	/* Esta funcion nos proporciona el nombre de la base de datos */
	function dbname()
	{
		global $db;
		return $db;
	}
	/*Esta funcion nos proporciona la contraseña de nuestro usuario*/
	function pass()
	{
		global $pass;
		return $pass;
	}
	/*Esta funcion nos permitira ejecutar una consulta en la base de datos, necesitando unicamente el codigo sql que
	contiene dicha consulta, y nos retornara el resultado de dicha consulta*/
	function consultar($sql)
	{
		$result=mysql_query($sql,con()) or die ($sql .mysql_error().""); 
		return $result;
	
	}
?>