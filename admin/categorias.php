<?php
session_start();
include('../php/conectar.php');
include('validarUsuario.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Inspection Venerica</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="../web/css/style.css" rel="stylesheet" type="text/css" media="all" />

<!-- start top_js_button -->
<script type="text/javascript" src="../web/js/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="../web/js/move-top.js"></script>
<script type="text/javascript" src="../web/js/easing.js"></script>
<script src="../js/notify.min.js"></script>
   <script type="text/javascript">
		ExampleData = {};
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
		});
	</script>

<script src="../js/jquery.mockjax.js"></script>
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
				<li><a href="reportes.php">Reportes</a></li>
				<li ><a href="usuarios.php">Usuarios</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar Sesion</a></li>
                <li class="active"><a href="categorias.php">Categorias</a></li>

			</ul>
		</div>
	<script type="text/javascript" src="../web/js/script.js"></script>
	<div class="clear"></div>

		<div class="clear"></div>
</div>
</div>
</div>

<!-- start main -->
<div class="wrap">
	<div class="main">
    <div class="tabla2" >
	 	 	<table width="100%">
            <tr>
                <td>Nombre Categoria</td>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
            <?php
				$sql="select * from categoria";
				$result=consultar($sql);
				$html='';
				while($row=mysql_fetch_assoc($result))
				{
					//echo "entre";
					$html.="<tr>";
					$html.= '<td align="center">'.$row["nombre"].'</td>';
					$html.= '<td align="center"><a href="editarCategoria.php?id='.$row["id"].'">Editar</a></td>';
					$html.= '<td align="center"><a href="#" onclick="eliminar('.$row["id"].')">Eliminar</a></td>';
					$html.='</tr>';
					
				}
				echo $html;
			?>	
            </table>
            </div>
            <br>
            <br>
            	 	 <div class="contact">				
					<div class="contact_info">
      				</div>
				  <div class="contact-form">
			 	 <div class="content">
		 	 		<h2>Crear Categoria</h2>
		 	 	</div>
            <form>
                <div>
                    <span><label>Nombre</label></span>
                    <span><input name="nombre" id="nombre" type="text" class="textbox" placeholder="Nombre" value=""></span>
                </div>
               <div>
                    <span><input type="submit" id="btnCrear" class="" value="Crear"></span>
              </div>
            </form>
            </div>
            <script type="text/javascript">
			var idU;
				function eliminar(id)
				{
					idU=id;
					$( "#dialog-confirm" ).dialog( "open" );
				}
				$(function() {
					 $( "#dialog-confirm" ).dialog({
						autoOpen:false,
						resizable: false,
						height:200,
						modal: true,
						buttons: 
						{
							"Eliminar": function() 
							{
								$.ajax({
									url:"../php/opcionesCategoria.php",
									type:"POST",
									data:{
										"opcion":"eliminar",
										"id":idU						
									},
									success: function(e)
									{
										
										if(e=="true")
										{
											alert("Categoria eliminada  con exito!");
											$(location).attr("href","categorias.php");
										}else{
											alert("Categoria no pudo ser eliminada");
										}
									}
								}).done(function()
								{
									$( this ).dialog( "close" );
								});
							},
							Cancel: function() 
							{
								$( this ).dialog( "close" );
							}
						}
					});	
					
					
				});
				$(document).ready(function(e) {
                    $("#btnCrear").click(function(e) 
					{
						e.preventDefault();
						//Variables
						var nombre=$("#nombre").val();
						$.ajax({
							url:"../php/opcionesCategoria.php",
							type:"POST",
							data:{
								"opcion":"crear",
								"nombre":nombre
							},
							success: function(e)
							{
								
								if(e=="true")
								{
									alert("Categoria creada con exito!");
									$(location).attr("href","categorias.php");
								}else if(e=="false"){
									alert("Categoria no pudo ser creada");
								}else if(e=="false1"){
									alert("Esa categoria ya se ha creado");
								}
							}
						});
						
					});
                });
			</script>
		</div>
</div>
<div id="dialog-confirm" title="Eliminar usuario">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>La Categoria sera eliminado. Esta seguro?</p>
</div>
<div class="footer_bg1">
<div class="wrap">
	
</div>
</div>
</body>
</html>