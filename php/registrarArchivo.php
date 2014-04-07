<?php
/* Aqui nos encargamos de incluir el archivo de conectar.php para poder acceder a todas sus funciones */
include('conectar.php');

/* 
	Aqui nos encargamos de obtener la informacion enviada desde la pagina formulario.php por el formulario
	Para poder obtener los datos enviados desde el formulario usamos la variable $_POST['nombre'], donde
	nombre es el nombre del cuadro de texto del formulario 
*/
	$idUsuario=$_POST['idUsuario'];
	$nombre=$_POST['nombre'];
	$codigo=$_POST['codigo'];

/* 
	Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
	como sabran para registrar informacion varchar debemos enviar con comillas
*/

$sql='insert into archivos (idUsuario,nombre, codigo) values ("'.$idUsuario.'",'.$nombre.',"'.$codigo.'")';

/* 
	Ahora ejecutamos el codigo sql,para eso llamamos la funcion que creamos en la clase conectar.php, sila funcion
	nos retorna un false, es porque ocurrio algun tipo de error
*/
	$resul=consultar($sql);
	if($resul==true)
	{
		echo 'Felicitaciones, se a registrado la persona exitosamente, puedes ingresar otro <a href="../formulario.php">Aqui</a>';
	}else{
		echo 'A ocurrido un error mientras se guardaba a la persona, les pedimos disculpas puede ser que la persona ya exista, </br>
				o dejaste algun campo vacio, puedes volver a intentarlo <a href="../formulario.php">Aqui</a>';
	}
?>