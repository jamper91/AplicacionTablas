<?php
/* Aqui nos encargamos de incluir el archivo de conectar.php para poder acceder a todas sus funciones */
include('conectar.php');
session_start();

 

/* 
	Aqui nos encargamos de obtener la informacion enviada desde la pagina formulario.php por el formulario
	Para poder obtener los datos enviados desde el formulario usamos la variable $_POST['nombre'], donde
	nombre es el nombre del cuadro de texto del formulario 
*/
	$usuario=$_POST['usuario'];
	$clave=$_POST['clave'];

/* 
	Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
	como sabran para registrar informacion varchar debemos enviar con comillas
*/

$sql='select * from usuario  where usuario="'.$usuario.'" and clave="'.$clave.'"';
$hayUsuarios=false;
/* 
	Ahora ejecutamos el codigo sql,para eso llamamos la funcion que creamos en la clase conectar.php, sila funcion
	nos retorna un false, es porque ocurrio algun tipo de error
*/
	$resul=consultar($sql);
	while ($row = mysql_fetch_assoc($resul))
		{
			//Guardo los datos en sesion
			$_SESSION['idUsuario']=$row['id'];
			$_SESSION['rol']=$row['rol'];
			echo $row['rol'];
			$hayUsuarios=true;
		}
		if(!$hayUsuarios)
			echo 'false';
?>