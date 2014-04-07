<?php
session_start();
include('../php/conectar.php');
include('validarUsuario.php');
$nombre=$_POST['txtNombre'];

//Si el nombre de la categoria es diferente de cero, la creo y la anexo a la inserccion del archivo
if($nombre!="")
{
	//VErifico que esa categoria no exista
		$sql='select * from categoria where nombre="'.$nombre.'"';
		$esta=false;
		$result1=consultar($sql);
		while($row=mysql_fetch_array($result1))
		{
			$esta=true;
		}
		if($esta==false)
		{
			$sql="insert into categoria (nombre) values('".$nombre."')";
			consultar($sql);
			//Ahora consulto el ultimo id creado
			$sql="select max(id) as id from categoria";
			$result=consultar($sql);
			while($row=mysql_fetch_assoc($result))
			{
				$categoria=$row["id"];
			}
		}else{
			$categoria="-1";
		}
	
	
}else{
	$categoria=$_POST["categoria"];
}
if($categoria!="-1")
{

$allowedExts = array("xls");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "application/vnd.ms-excel"))
&& (($_FILES["file"]["size"]/1024) < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {

    if (file_exists("upload/" .$_FILES["file"]["name"].'.xls'))
      {
	  header('Location: subir.html?mensaje=Archivo ya existe');
      }
    else
      {
		  
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"].'.xls');
	  //Luego de haber subido el archivo, lo almaceno en la base de datos
	  $sql='insert into archivos (idCategoria, idUsuario, ruta,nombre) values("'.$categoria.'.xls",'.$_SESSION['idUsuario'].',"admin/upload/'.$_FILES["file"]["name"].'.xls","'.$_FILES["file"]["name"].'")';
	  $resul=consultar($sql);
	  if($resul==true)
	  {
			header('Location: index.html?mensaje=Ok');		  
	  }else{
		  header('Location: subir.html?mensaje=Problemas al almacenar en la base de datos');
	  }
      }
	  
	  
    }
  }
else
  {
  header('Location: subir.php?mensaje=Archivo no permitido');
  }
}else{
	header('Location: subir.php?mensaje=Categoria ya existe');
}
?>