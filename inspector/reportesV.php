<?php
session_start();
include('../php/conectar.php');
include('validarUsuario.php');
//Consulto todos los usuarios del sistema
$usuarios= array();
$sql="select * from usuario";
$result=consultar($sql);
while($row=mysql_fetch_array($result))
{
	$usu= array($row["id"],$row["nombre"]);
	array_push($usuarios,$usu);
	
}

//Obtiene el nombre del usuario con el id
function getUsuario($id)
{
	//REcorro los usuarios
	$usuarios=$GLOBALS["usuarios"];
	foreach($usuarios as $usuario)
	{
		if($usuario[0]==$id)
		{
			return $usuario[1];
		}
	}
	return "null";
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
<script type="text/javascript" src="../web/js/jquery.min.js"></script>
<script type="text/javascript" src="../web/js/move-top.js"></script>
<script type="text/javascript" src="../web/js/easing.js"></script>
   <script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
		});
	</script>
</head>
<body>
<!-- start header -->
<div class="header_bg">
<div class="wrap">
	<div class="header">
		<div class="logo">
			<a href="../index.html"><img src="../web/images/logo.png" alt=""/> </a>
		</div>
		<div class="social-icons">
		    <ul>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
			</ul>
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
				<li><a href="../index.html">Inicio</a></li>
				<li class="active"><a href="archivos.php">Archivos</a></li>
			</ul>
		</div>
		<div class="h_search">
    		<form>
    			<input type="text" value="" placeholder="search something...">
    			<input type="submit" value="">
    		</form>
		</div>

        <div class="search">
            <form action="/iphone/search.html">
                <input type="text" value="Search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Search';}" class="text">
            </form>
        </div>
        <div class="sub-head">
        	<ul>
            	<li><a href="../#" id="menu">Menu  <span></span></a></li>
            	<li><a href="../#" id="search">Search <span></span></a></li>
            </ul>
            <div class="clear"></div>
        </div>
	   <script type="text/javascript">
		$(".menu,.search").hide();
		$("#menu").click(function(){
			$(".menu").toggle();
			$(".search").hide();
			$("#search").removeClass("active");
			$("#menu").toggleClass("active");
		});
		$("#search").click(function(){
			$(".search").toggle();
			$(".menu").hide();
			$("#menu").removeClass("active");
			$("#search").toggleClass("active");
			$(".text").focus();
		});
	</script>
	<script type="text/javascript" src="../web/js/script.js"></script>
	<div class="clear"></div>

		<div class="clear"></div>
</div>
</div>
</div>
<!-- start top_bg -->
<div class="top_bg">
<div class="wrap">
	<div class="top">
		<h2>Archivos</h2>
 	</div>
</div>
</div>
<!-- start main -->
<div class="wrap">
<div class="main">
		<!-- start span_of_3 -->
		<div class="span_of_3">
        	<?php
				//Me encargo de consultar lor archivos que haya subido el administrador
				$sql="select * from historial";
				
				$resul=consultar($sql);
				$i=0;
				while ($row = mysql_fetch_assoc($resul))
				{
			?>
			<div class="span1_of_3">
				<a href="#l"><img src="../images/excel.png" alt=""></a>
				<div class="span1_of_3_text">
					<h3><a href="ver.php?id=<?=$row['id']?>">Archivo:<?=$row['nombre']?></a></h3>
					<p>Fecha:<?=$row['fecha']?></p>
                    <p>Version:<?=$row['version']?></p>
                    <p>Usuario:<?=getUsuario($row['idUsuario'])?></p>
			  </div>
				<div class="ser_btn">
					<a class="button  ser_btn1" href="ver.php?id=<?=$row['id']?>">Ver</a>
				</div>
		  </div>
            <?php
				}
				$i++;
				if($i%3==0)
					echo '<div class="clear"></div>';
			?>
			<div class="clear"></div>
	</div>
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
		<div class="social-icons">
		    <ul>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
			</ul>
		</div>
		<div class="copy">
			<p class="link"><span>&copy; 2014 Webworld-v2. All rights reserved | Template by&nbsp;<a href="../http://w3layouts.com/"> W3Layouts</a></span></p>
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
</body>
</html>