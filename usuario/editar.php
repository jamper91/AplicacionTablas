<?php
ini_set("memory_limit","1024M");
include '../excel_reader.php';     // include the class
include('../php/conectar.php');
include('validarUsuario.php');
// creates an object instance of the class, and read the excel file data
$excel = new PhpExcelReader;
$idArchivo=$_GET["id"];
//Obtengo la informacion del archivo que llegar por la url

$sql="select * from archivos where id=".$idArchivo;
$result=consultar($sql);
$ruta="";
while ($row = mysql_fetch_assoc($result))
{
	$ruta=$row['ruta'];
}
//$excel->read('preoperational.xls');
$excel->read('../'.$ruta);

// Excel file data is stored in $sheets property, an Array of worksheets
/*
The data is stored in 'cells' and the meta-data is stored in an array called 'cellsInfo'

Example (firt_sheet - index 0, second_sheet - index 1, ...):

$sheets[0]  -->  'cells'  -->  row --> column --> Interpreted value
         -->  'cellsInfo' --> row --> column --> 'type' (Can be 'date', 'number', or 'unknown')
                                            --> 'raw' (The raw data that Excel stores for that data cell)
*/


// this function creates and returns a HTML table with excel rows and columns data
// Parameter - array with excel worksheet data
function sheetData($sheet,$nom) {
  
  //Variable para saber si pinto checkbox
$pintarC=False;
//VAraible para saber las posiciones donde se pintara el checbox
$posicionC=array();
$posC=0;
$filC=0;
//Variable para saber si pinto un datetime
$pintarD=false;
//Variable par saber las posiciones donde se pintara el datepicker
$posicionD=array();
$posD=0;
$filD=0;
	$re='<form class="formEnviar" id="'.$nom.'" action="imprimir.php" method="post" >	<input type="textarea" id="txtHtml'.$nom.'" name="txtHtml"  style="display:none"/>	<INPUT type="submit" value="" style="background-image: url(\'../images/imprimir.png\');background-size: contain;  width: 80px;  height: 80px;   background-color: #FFFFFF;  border: medium none;"> </form><div id="contenedor'.$nom.'" class="TablaAzul">
			';
  $re .= '<table id="example'.$nom.'"  border="1" cellspacing="1" cellpadding="1" >';     // starts html table

  $x = 1;
  while($x <= $sheet['numRows']) {
    $re .= "<tr>\n";
    $y = 1;
    while($y <= $sheet['numCols']) {
      $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
	  $cellInfo =	isset($sheet['cellsInfo'][$x][$y]['colspan']) ? $sheet['cellsInfo'][$x][$y]['colspan'] : null;	
			
		  if($cell=="Monday" )
		  {
			  
			$pintarC=false;
			$posicionC=array();
			$posC=0;
			$pintarD=false;
			$posicionD=array();
			$posD=0;
		  }
		 
	   if($pintarC==false)
	   {
			if($cell=="Y" || $cell=="N" || $cell=="Yes" || $cell=="No")
			{
					//$pintarC=true;
					$posicionC[$posC]=$y;
					$posC++;
					$filC=$x;
			}
				  
			
	   }
	   if($pintarD==false)
	   {
			if($cell=="Date")
			{
					//$pintarC=true;
					$posicionD[$posD]=$y;
					$posD++;
					$filD=$x;
			}
			
	   }
	   
	   $cols=1;
	   if($cellInfo!=null)
	   {
			$cols=$cellInfo;
	   }
	   if($x>$filC && in_array($y,$posicionC))
	   {
		   	if($cell=="")
				$re.="<td colspan='$cols'><input type='checkbox'> <img src='../images/check.png' border=0 width='24' height='24' style='display:none' /></td>";
			else
			{
				$re.="<td colspan='$cols'><input  type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
				$pintarC=false;
				$posicionC=array();
				$posC=0;
				
			}
			
	   }elseif($x>$filD && in_array($y,$posicionD))
	   {
		   if($cell=="")
			$re.="<td colspan='$cols'><input  class='fecha' type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
			else
			{
				$re.="<td colspan='$cols'><input  type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";	
				$pintarD=false;
				$posicionD=array();
				$posD=0;			
			}

			
	   }else{
			if($cols>1){
				$re .= " <td colspan='$cols' align='center'><input type='text' value='$cell' style='display:none;' /><label>$cell</label></td>";  
				
				}else
			$re .= " <td><input type='text' value='$cell' style='display:none;' /><label>$cell</label></td>";  
	   }
	   $y+=$cols-1;
	   
			
      $y++;
    }  
    $re .= "</tr>\n";
    $x++;
  }

  return $re .'</table></div>';     // ends and returns the html table
}

$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet

$pestanas="<ul>";
$tabs="";
// traverses the number of sheets and sets html table with each sheet data in $excel_data
for($i=0; $i<$nr_sheets; $i++) 
{
  $pestanas.="<li><a href='#tabs-$i'>";
  $pestanas.=$excel->boundsheets[$i]['name']."</a><li>";
  $tabs.="<div id='tabs-$i'>".sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name'])."</div>";
  //$excel_data .= '<h4>Hola '. ($i + 1) .' (<em>'. $excel->boundsheets[$i]['name'] .'</em>)</h4>'. sheetData($excel->sheets[$i]) .'<br/>';  
}
$pestanas.="</ul>";
?>
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Inspection Venerica</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="../web/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- start top_js_button -->
<!--<script type="text/javascript" src="../web/js/jquery.min.js"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="../web/js/move-top.js"></script>
<script type="text/javascript" src="../web/js/easing.js"></script>
<script type="text/javascript" src="http://malsup.github.io/jquery.blockUI.js"></script>
<script src="../js/notify.min.js"></script>
   <script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
		});
	</script>
	<style type="css">

	</style>
</head>
<body>
<!-- start header -->
<div class="header_bg">
<div class="wrap">
	<div class="header">
		<div class="logo">
			<a href="index.html"><img src="../web/images/logo.png" alt=""/> </a>
		</div>

		<div class="clear"></div>
	</div>
</div>
</div>
<!-- start header -->
<div class="header_btm">
<div class="wrap">
	<div class="header_sub">
		<div class="h_menu">
			<ul>
				<li class="active"><a href="index.html">Inicio</a></li>
				<li><a href="archivos.php">Reporte</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar Sesion</a></li>
				<!--<li><a href="historial.php">Historial</a></li>-->

			</ul>
		</div>
	<script type="text/javascript" src="../web/js/script.js"></script>
	<div class="clear"></div>

		<div class="clear"></div>
</div>
</div>
</div>
<div class="wrap">

			<div>
            	<br/>
		 	 	<h2 style="font-size:1.5em; text-transform:uppercase; color::#777777;">Crear reporte</h2>
		 	 </div>
		<!-- Un boton general, para guardar los cambios en todas las pestañas -->
        <form class="contact-form">            
        	<input type="submit" id="btnGuardar" value="Guardar" />
        </form>
		<div  id="tabs">
			<?php
			// Aqui se mostraran las pestanas, es una pestaña por cada hoja 
			echo $pestanas;
			//aqui se mostrara cada hoja
			echo $tabs;
			?>   
		
		
		</div>
		
		<div class="clear"></div>
		<script>
		  $(function() {
			$( "#tabs" ).tabs();
		  });
		  </script>
</div>

<div class="footer_bg1">
<div class="wrap">
	<div class="footer1">
		<!-- scroll_top_btn -->
	    <script type="text/javascript">
			$(document).ready(function() {
			
				var defaults = {
		  			containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
		 		};
				
				
				$().UItoTop({ easingType: 'easeOutQuart' });
				
			});
		</script>
		 <a href="../#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>

		<div class="clear"></div>
	</div>
</div>
</div>
<script type="text/javascript">
 
$(document).ready(function(){
	//Muestro un mensaje de "Cargando" cuando se esta generando el html de la tabla
	(function()
	{
		$( ".fecha" ).datepicker();
	})();
	
     //Esta funcion es para guardar los cakbios en la base de datos
	 $("#btnGuardar").click(function(e) {
        e.preventDefault();
		
		//Primero verifico que el campo nombre no este vacio
		
			//Tomo los datos a enviar al ajax
			$.blockUI(
			{
				message: "Guardando el archivo, por favor espera", 
				css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} 
			}); 
			var codigoHtml=$("#tabs").html();
			$.ajax({
				url:"guardar.php",
				type:"POST",
				data:{
					"codigo":codigoHtml,
					"nombre":nombre,
					"idarchivo":<?=$idArchivo?>
				},
				success: function(e)
				{
					 $.unblockUI(); 
					if(e=="Insert")
					{
						$.notify("Archivo almacenado con exito","success");
					}else if(e=='Update'){
						$.notify("Archivo actualizado con exito","success");
					}else if(e=="Error Insert"){
						$.notify("El archivo no se pudo insertar","error");
					}
					else if(e=="Error Update"){
						$.notify("El archivo no se pudo  actualizar","error");
					}
				}
			});	
		
    });
	 
	 //Busco los checks que se hayan seleccionado y los cambio por una imagen
		$(".TablaAzul :checkbox").click(function()
		{
			//Oculto el checkbox
			$(this).css('display','none');
			//Muestro la imagen
			$(this).next().css('display','block');
			
		});
	 //Busco las imagenes de "check" que se seleccionen y las cambio por el check
		$(".TablaAzul img").click(function()
		{
			//Oculto el checkbox
			$(this).css('display','none');
			//Muestro la imagen
			$(this).prev().css('display','block');
			//Quito el check al checkbox
			$(this).prev().attr('checked',false);

			
		});
	 //Esta funcion se va a llamar cuando se de clic en imprimir
	 $('.formEnviar').submit(function()
	 {
		//Oculto todos los inputs	
		//$("#example input[type='text']").remove();
		$(".TablaAzul input[type='text']").each(function()
		{
			$(this).css('display','none');
		});
		//Oculto todos los checkbox
		//$("#example :checkbox").remove();
		$(".TablaAzul :checkbox").each(function()
		{
			$(this).css('display','none');
		});
		//Muestro todos los labeles
		$(".TablaAzul label").each(function()
		{
			$(this).css('display','block');
		});

		//Tomo el codigo html
		var html=$("#contenedor"+$(this).attr('id')).html();
		$('#txtHtml'+$(this).attr('id')).val(html);
		
	 });
	 //Esta funcion se llama cuando se oprime cualquier celda de la tabla (incluye todas las pestañas
	 $('.TablaAzul td').click(function()
	 {	
		//Oculto todos los otros elementos
		$('.TablaAzul input[type="text"]').each(function()
		{
			$(this).css('display','none');
		});
		//Muestro todos los labeles
		$('.TablaAzul label').each(function()
		{
			$(this).css('display','block');
		});
		//muestro el cuadro de texto de la celda actual
		$(this).find('input[type="text"]').css('display','block');
		//oculto el label de la celda actual
		$(this).find('label').css('display','none');
		//Doy el foco a la celda actual
		$(this).find('input[type="text"]').focus();
	 });
	 //Esto es para que cuando se digite algo en un cuadro de texto, se vea reflejado en su label
	 $('.TablaAzul input[type="text"]').change(function()
	 {
		$(this).next().text($(this).val());
	 });
});
</script>
<div id="domMessage" style="display:none;"> 
    <h1>We are processing your request.  Please be patient.</h1> 
</div> 
</body>
</html>