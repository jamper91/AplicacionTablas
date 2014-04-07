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
			<a href="../index.html"><img src="../web/images/logo.png" alt=""/> </a>
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
				<li class="active"><a href="usuarios.php">Usuarios</a></li>
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

<!-- start main -->
<div class="wrap">
	<div class="main">
    <div class="tabla2" >
	 	 	<table width="100%">
            <tr>
                <td>Usuario</td>
                <td>Rol</td>
                <td>Nombre</td>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
            <?php
				$sql="select * from usuario";
				$result=consultar($sql);
				$html='';
				while($row=mysql_fetch_assoc($result))
				{
					//echo "entre";
					$html.="<tr>";
					$html.= '<td align="center">'.$row["usuario"].'</td>';
					$html.= '<td align="center">'.$row["rol"].'</td>';
					$html.= '<td align="center">'.$row["nombre"].'</td>';
					$html.= '<td align="center"><a href="editarUsuario.php?id='.$row["id"].'">Editar</a></td>';
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
		 	 		<h2>Crear Usuario</h2>
		 	 	</div>
            <form>
                <div>
                    <span><label>Usuario</label></span>
                    <span><input name="usuario" id="usuario" type="text" class="textbox" placeholder="Usuario" value=""></span>
                </div>
                <div>
                    <span><label>Nombre</label></span>
                    <span><input name="nombre" id="nombre" type="text" class="textbox" placeholder="Nombre" value=""></span>
                </div>
                <div>
                    <span><label>Rol</label></span>
                    <span>
                        <select id="rol" name="rol">
                            <option value="admin">Administrador</option>
                            <option value="usuario">Usuario</option>
                            <option value="inspector">Inspector</option>
                        </select>
                    </span>
                </div>
                <div>
                    <span><label>Clave</label></span>
                    <span><input name="clave" id="clave" type="password" class="textbox" ></span>
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
									url:"../php/opcionesUsuario.php",
									type:"POST",
									data:{
										"opcion":"eliminar",
										"id":idU						
									},
									success: function(e)
									{
										
										if(e=="true")
										{
											alert("Usuario eliminado  con exito!");
											$(location).attr("href","usuarios.php");
										}else{
											alert("Usuario no pudo ser eliminado");
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
						var usuario=$("#usuario").val();
						var rol=$("#rol").val();
						var clave=$("#clave").val();
						$.ajax({
							url:"../php/opcionesUsuario.php",
							type:"POST",
							data:{
								"opcion":"crear",
								"nombre":nombre,
								"usuario":usuario,
								"rol":rol,
								"clave":clave
							},
							success: function(e)
							{
								console.log(e);
								if(e=="true")
								{
									alert("Usuario creado con exito!");
									$(location).attr("href","usuarios.php");
								}else{
									alert("Usuario no pudo ser creado");
								}
							}
						});
						
					});
                });
			</script>
		</div>
</div>
<div id="dialog-confirm" title="Eliminar usuario">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>El usuario sera eliminado. Esta seguro?</p>
</div>
<div class="footer_bg1">
<div class="wrap">
	
</div>
</div>
</body>
</html>