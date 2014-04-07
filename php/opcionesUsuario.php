<?php
/* Aqui nos encargamos de incluir el archivo de conectar.php para poder acceder a todas sus funciones */
include('conectar.php');

$opcion=$_POST['opcion'];

if($opcion=="crear")
{
	/* 
	Aqui nos encargamos de obtener la informacion enviada desde la pagina formulario.php por el formulario
	Para poder obtener los datos enviados desde el formulario usamos la variable $_POST['nombre'], donde
	nombre es el nombre del cuadro de texto del formulario 
	*/
		$nom=$_POST['nombre'];
		$usuario=$_POST['usuario'];
		$clave=$_POST['clave'];
		$rol=$_POST['rol'];
	
	/* 
		Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
		como sabran para registrar informacion varchar debemos enviar con comillas
	*/
	
	$sql='insert into usuario (usuario,clave, nombre,rol) values ("'.$usuario.'","'.$clave.'","'.$nom.'","'.$rol.'")';
	
	/* 
		Ahora ejecutamos el codigo sql,para eso llamamos la funcion que creamos en la clase conectar.php, sila funcion
		nos retorna un false, es porque ocurrio algun tipo de error
	*/
		$resul=consultar($sql);
		if($resul==true)
		{
			echo 'true';
		}else{
			echo 'false';
		}	
}
if($opcion=="actualizar")
{
	/* 
	Aqui nos encargamos de obtener la informacion enviada desde la pagina formulario.php por el formulario
	Para poder obtener los datos enviados desde el formulario usamos la variable $_POST['nombre'], donde
	nombre es el nombre del cuadro de texto del formulario 
	*/
		$nom=$_POST['nombre'];
		$usuario=$_POST['usuario'];
		$rol=$_POST['rol'];
		$id=$_POST['id'];
	
	/* 
		Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
		como sabran para registrar informacion varchar debemos enviar con comillas
	*/
	
	$sql="UPDATE usuario set usuario='".$usuario."', rol='".$rol."', nombre='".$nom."' where id=".$id;
	
	/* 
		Ahora ejecutamos el codigo sql,para eso llamamos la funcion que creamos en la clase conectar.php, sila funcion
		nos retorna un false, es porque ocurrio algun tipo de error
	*/
		$resul=consultar($sql);
		if($resul==true)
		{
			echo 'true';
		}else{
			echo 'false';
		}	
}
if($opcion=="eliminar")
{
	$id=$_POST["id"];
	$sql="delete from usuario where id=".$id;
	$resul=consultar($sql);
		if($resul==true)
		{
			echo 'true';
		}else{
			echo 'false';
		}	
}

?>