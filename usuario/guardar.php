<?php
session_start();
include('../php/conectar.php');
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

$codigo=$_POST['codigo'];
$idARchivo=$_POST['idarchivo'];
$fecha=$_POST['fecha'];
//echo $fecha."--";
if($fecha=="" || $fecha==null)
{
	$fecha=date ("y-m-d");
}
//echo $fecha."--";
//Remplazo todos lo " por '
$codigo= str_replace("'",'"',$codigo);

//Obtengo la version del archivo
$sql="select IFNULL(max(version),0) as version from historial where idArchivo=".$idARchivo." and idUsuario=".$_SESSION['idUsuario'];
$result=consultar($sql);
$yaExiste=false;
while ($row = mysql_fetch_assoc($result))
{
	$version=$row["version"];
	$version+=1;
	$yaExiste=true;
	//Actualizo
	$sql="insert into historial(idUsuario,codigo,idArchivo,version,fecha) values(".$_SESSION['idUsuario'].",'".$codigo."',".$idARchivo.",".$version.",'".$fecha."')";
	$result1=consultar($sql);
	if($result1)
		echo 'Update';
	else
		echo 'Error Update';
	
}

/*$sql="insert into historial(idUsuario,codigo,idArchivo) values(".$_SESSION['idUsuario'].",'".$codigo."',".$idARchivo.")";
$result=consultar($sql);
if($result)
	echo 'Insert';
else
	echo 'Error Insert';*/
//Verifico si ya exsite un archivo de ese usuario con ese nombre, para actualizarlo
/*$sql="select id from historial where idUsuario=".$_SESSION['idUsuario']." and nombre='".$nombre."'";
$result=consultar($sql);
$yaExiste=false;
$re="";
while ($row = mysql_fetch_assoc($result))
{
	$yaExiste=true;
	//Actualizo
	$sql="update historial set codigo='".$codigo."' where idUsuario=".$_SESSION['idUsuario']." and nombre='".$nombre."'";
	$result=consultar($sql);
	if($result)
		echo 'Update';
	else
		echo 'Error Update';
	
}
if(!$yaExiste)
{
	$sql='insert into historial (idUsuario,codigo,nombre,idArchivo) values('.$_SESSION['idUsuario'].',\''.$codigo.'\',"'.$nombre.'",'.$idARchivo.')';
	$result=consultar($sql);	
	if($result)
		echo 'Insert';
	else
		echo 'Error Insert';

}*/


?>