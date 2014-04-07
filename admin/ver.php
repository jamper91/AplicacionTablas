<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once '../excel_reader2.php';
include('../php/conectar.php');
include('validarUsuario.php');
$idArchivo = $_GET["id"];
//Obtengo la informacion del archivo que llegar por la url

$sql    = "select * from archivos where id=" . $idArchivo;
$result = consultar($sql);
$ruta   = "";
while ($row = mysql_fetch_assoc($result)) {
    $ruta = $row['ruta'];
    $nom_tabla = $row['nombre'];
}
$data = new Spreadsheet_Excel_Reader('../' . $ruta);

$nr_sheets  = sizeof($data->sheets); // gets the number of sheets
$excel_data = ''; // to store the the html tables with data of each sheet

$pestanas = "<ul>";
$tabs     = "";
// traverses the number of sheets and sets html table with each sheet data in $excel_data
for ($i = 0; $i < $nr_sheets; $i++) {
    $pestanas .= "<li><a href='#tabs-$i'>";
    $pestanas .= "Hoja $i</a><li>";
    $tabs .= "<div id='tabs-$i'>" . sheetData($i, "Hoja") . "</div>";
    //$excel_data .= '<h4>Hola '. ($i + 1) .' (<em>'. $excel->boundsheets[$i]['name'] .'</em>)</h4>'. sheetData($excel->sheets[$i]) .'<br/>';  
}
$pestanas .= "</ul>";




function sheetData($sheet, $nom)
{
    global $data;
	//Variable para saber si una fila esta vaci
	$vacio=true;
    //Variable para saber si pinto checkbox
    $pintarC   = false;
    //VAraible para saber las posiciones donde se pintara el checbox
    $posicionC = array();
    $posC      = 0;
    $filC      = 0;
    //Variable para saber si pinto un datetime
    $pintarD   = false;
    //Variable par saber las posiciones donde se pintara el datepicker
    $posicionD = array();
    $posD      = 0;
    $filD      = 0;
    $ret        = '<form class="formEnviar" id="' . $nom . '" action="imprimir.php" method="post" >	<input type="textarea" id="txtHtml' . $nom . '" name="txtHtml"  style="display:none"/>	<INPUT type="submit" value="" style="background-image: url(\'../images/imprimir.png\');background-size: contain;  width: 80px;  height: 80px;   background-color: #FFFFFF;  border: medium none;"> </form><div id="contenedor' . $nom . '" class="excel">
			';
    $ret .= '<table id="example' . $nom . '"  width="100%">'; // starts html table
    $x = 1;
    
    
    $rows = $data->rowcount($sheet);
    $colums = $data->colcount($sheet);
    for ($r = 0; $r <= $rows; $r++) {
		$vacio=true;
        $re = "<tr>\n";
        $y = 1;
        for ($c = 0; $c <= $colums; $c++) {
            $cell   = $data->val($r, $c, $sheet);
            $rowspa = $data->rowspan($r, $c, $sheet);
            $cols   = $data->colspan($r, $c, $sheet);
            $style  = $data->style($r, $c, $sheet);
			//Aquellas celdas que no tienen nada de estilo, les agrego un borde
            if($style=="")
				$style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-top:1px";
			//Aquellas celdas que no tienes borde left, lo agrego
			if(strpos($style,"border-left")!==true)
			{
				$style.="border-left:1px solid;";
			}
			if(strpos($style,"border-right")!==true)
			{
				$style.="border-right:1px solid;";
			}
			if(strpos($style,"border-bottom")!==true)
			{
				$style.="border-bottom:1px solid;";
			}
			if(strpos($style,"border-top")!==true)
			{
				$style.="border-top:1px solid;";
			}
			if($cell!="")
				$vacio=false;
			
            if ($cell == "Monday") {
                
                $pintarC   = false;
                $posicionC = array();
                $posC      = 0;
                $pintarD   = false;
                $posicionD = array();
                $posD      = 0;
            }
            if ($pintarC == false) {
                if ($cell == "Y" || $cell == "N" || $cell == "Yes" || $cell == "No") {
                    //$pintarC=true;
                    $posicionC[$posC] = $c;
                    $posC++;
                    $filC = $r;
                }
                
                
            }
            if ($pintarD == false) {
                if ($cell == "Date") {
                    //$pintarC=true;
                    $posicionD[$posD] = $c;
                    $posD++;
                    $filD = $r;
                }
                
            }
            if ($r > $filC && in_array($c, $posicionC)) {
                if ($cell == "")
                    $re .= "<td colspan='$cols' style='$style'><input type='checkbox'> <img src='../images/check.png' border=0 width='24' height='24' style='display:none' /></td>";
                else {
                    $re .= "<td colspan='$cols' style='$style'><input  type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
                    $pintarC   = false;
                    $posicionC = array();
                    $posC      = 0;
                    
                }
                
            } elseif ($r > $filD && in_array($c, $posicionD)) {
                if ($cell == "")
                    $re .= "<td colspan='$cols' style='$style'><input  class='fecha' type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
                else {
                    $re .= "<td colspan='$cols' style='$style'><input  type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
                    $pintarD   = false;
                    $posicionD = array();
                    $posD      = 0;
                }
                
                
            } else {
                if ($cols > 1) {
                    $re .= " <td colspan='$cols' style='$style' align='center'><input type='text' value='$cell' style='display:none;' /><label>$cell</label></td>";
                    
                } else
                    $re .= " <td style='$style'><input type='text'  value='$cell' style='display:none;' /><label>$cell</label></td>";
            }
            $c = $c + ($cols - 1);
        }
			//Si esta vacio, vuelvo a recorrer la final, pero solo agreg el valor del texto, no agrego checks, ni calendar
		if($vacio)
		{
			$re="<tr style='height:19px;'>";
			$y=1;
			for ($c = 0; $c <= $colums; $c++)  
			{
				$cell   = $data->val($r, $c, $sheet);
    	        $rowspa = $data->rowspan($r, $c, $sheet);
        	    $cols   = $data->colspan($r, $c, $sheet);
            	$style  = $data->style($r, $c, $sheet);
			   	$re .= "<td colspan='$cols' style='$style'><input  type='text' value='$cell' style='display:none;'  /><label>$cell</label></td>";
				$c = $c + ($cols - 1);
			}
		}
        $re .= "</tr>\n";
		$ret.=$re;
    }
    return $ret . '</table></div>'; // ends and returns the html table
}
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
	<style>
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
				<li ><a href="index.html">Inicio</a></li>
				<li><a href="subir.php">Crear Tabla</a></li>
				<li class="active"><a href="archivos.php">Ver Tablas</a></li>
				<li><a href="reportes.php">Reportes</a></li>
				<li ><a href="usuarios.php">Usuarios</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar Sesion</a></li>
                <li ><a href="categorias.php">Categorias</a></li>

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
		 	 	<h2 style="font-size:1.5em; text-transform:uppercase; color::#777777;">Tabla: <?=$nom_tabla?></h2>
		 	 </br>
		 	 </div>
		<!-- Un boton general, para guardar los cambios en todas las pestañas -->
      <!--  <form class="contact-form">
        	
        	<input type="submit" id="btnGuardar" value="Guardar" />
        </form>-->
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
		<!--end scroll_top_btn -->
		<div class="clear"></div>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
    $("input[type=checkbox]").each(function(index, element) {
        $(this).css("display","none");
    });
});
</script>
<div id="domMessage" style="display:none;"> 
    <h1>We are processing your request.  Please be patient.</h1> 
</div> 
</body>
</html>