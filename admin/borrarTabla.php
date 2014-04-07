<?php
session_start();
include('../php/conectar.php');

$idTabla=$_POST['idtabla'];

//Obteno la informacion de la tabla, para borrar el archivo fisico
$sql="select ruta from archivos where id=".$idTabla;
$result=consultar($sql);
while ($row = mysql_fetch_assoc($result))
{
	//Elimino el archivo
	if(unlink("../".$row['ruta']))
	{
		//Borro el registro de la base de datos
		$sql='delete from archivos where id='.$idTabla;
		$result1=consultar($sql);
		if($result1==true)
			echo 'ok';
		else
			echo "false";
	}
}

?>