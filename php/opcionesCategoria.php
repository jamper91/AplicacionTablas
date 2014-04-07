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
		
		//VErifico que esa categoria no exista
		$sql='select * from categoria where nombre="'.$nom.'"';
		$esta=false;
		$result1=consultar($sql);
		while($row=mysql_fetch_array($result1))
		{
			$esta=true;
		}
		if($esta==false)
		{
			/* 
			Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
			como sabran para registrar informacion varchar debemos enviar con comillas
		*/
		
		$sql='insert into categoria (nombre) values ("'.$nom.'")';
		
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
		}else
		{
			echo 'false1';
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
		$id=$_POST['id'];
	
	/* 
		Luego de obtener la informacion debemos generar el codigo sql que se encarge de insertar en la bd
		como sabran para registrar informacion varchar debemos enviar con comillas
	*/
	
	$sql="UPDATE categoria set nombre='".$nom."' where id=".$id;
	
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
	$sql="delete from categoria where id=".$id;
	$resul=consultar($sql);
		if($resul==true)
		{
			echo 'true';
		}else{
			echo 'false';
		}	
}

?>