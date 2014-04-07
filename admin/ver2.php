<?php
session_start();
include('../php/conectar.php');
include('validarUsuario.php');
$idArchivo=$_GET["id"];
//Obtengo la informacion del archivo que llegar por la url

$sql="select * from historial h,archivos a where  a.id=h.idArchivo AND   h.id=".$idArchivo;
$result=consultar($sql);
$codigo="";
$nombre="";
while ($row = mysql_fetch_assoc($result))
{
	$codigo=$row['codigo'];
	$nombre=$row['nombre'];
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
<script src="../js/notify.min.js"></script>
<script type="text/javascript" src="http://malsup.github.io/jquery.blockUI.js"></script>
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
				<li ><a href="index.html">Inicio</a></li>
				<li><a href="subir.php">Crear Tabla</a></li>
				<li><a href="archivos.php">Ver Tablas</a></li>
				<li class="active"><a href="reportes.php">Reportes</a></li>
				<li ><a href="usuarios.php">Usuarios</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar Sesion</a></li>
                <li ><a href="categorias.php">Categorias</a></li>
			</ul>
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
	<!--<div class="top">
		<h2>Editando</h2>
 	</div>-->
</div>
</div>
<!-- start main -->
<div class="wrap">

			<div>
            	<br/>
		 	 	<h2 style="font-size:1.5em; text-transform:uppercase; color::#777777;">Archivo: <?=$nombre?></h2>
		 	 </div>
		<!-- Un boton general, para guardar los cambios en todas las pestañas -->
       <!-- <form class="contact-form">
        	<span><label>Nombre:</label></span>
        	<input type="text" id="txtNombre" value="<?=$nombre?>" disabled />
            
        	<input type="submit" id="btnGuardar" value="Guardar" />
        </form>-->
		<div  id="tabs">
			<?php

			//echo $codigo;
			echo str_replace('"../images/imprimir.png"', "'../images/imprimir.png'", $codigo);

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
		<!--<div class="social-icons">
		    <ul>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
		      <li><a href="../#" target="_blank"></a></li>
			  <li><a href="../#" target="_blank"></a></li>
			</ul>
		</div>-->
		<div class="copy">
			<!--<p class="link"><span>&copy; 2014 Webworld-v2. All rights reserved | Template by&nbsp;<a href="../http://w3layouts.com/"> W3Layouts</a></span></p>-->
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
<script type="text/javascript">
 
 //Desabilito todos los checkbox
 $(document).ready(function(e) {
    $("input[type=checkbox]").each(function(index, element) {
        $(this).css("display","none");
    });
});
 
/*$(document).ready(function(){
     //Esta funcion es para guardar los cakbios en la base de datos
	 $("#btnGuardar").click(function(e) {
        e.preventDefault();
		
		//Primero verifico que el campo nombre no este vacio
		var nombre=$("#txtNombre").val();
		if(nombre!="")
		{
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
			//Tomo los datos a enviar al ajax
			var codigoHtml=$("#tabs").html();
			$.ajax({
				url:"guardar.php",
				type:"POST",
				data:{
					"codigo":codigoHtml,
					"nombre":nombre
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
		}else{
			$.notify("El campo nombre no puede estar vacio","warn");
		}
		
    });
	 
	 //Busco los checks que se hayan seleccionado y los cambio por una imagen
		$(".TablaAzul :checkbox").click(function()
		{
			//Oculto el checkbox
			$(this).css('display','none');
			//Muestro la imagen
			$(this).next().css('display','block');
			
		});
	 //Esta funcion se va a llamar cuando se de clic en guardar
	 $('.formEnviar').submit(function()
	 {
		//Elimino todos los inputs	
		$("#example input[type='text']").remove();
		//Elimino todos los checkbox
			$("#example :checkbox").remove();
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
});*/
</script>
</body>
</html>