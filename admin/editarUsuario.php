<?php
	session_start();
    include("../php/conectar.php");
	include('validarUsuario.php');
?>
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
<script src="../js/notify.min.js"></script>
   <script type="text/javascript">
   //Function para obtener las variables de la url
	function getUrlVars()
	{
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	$(function()
	{
		//Determino si me llega algun mensaje para mostrarlo con una notificacion
		var variables=getUrlVars();
		if(variables["mensaje"])
		{
			$.notify(variables["mensaje"],"error");
		}
	})();
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
				<li><a href="usuarios.php">Usuarios</a></li>
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
	 	 <div class="contact">				
					<div class="contact_info">
      				</div>
				  <div class="contact-form">
			 	 <div class="content">
		 	 		<h2>Editar Usuario</h2>
		 	 	</div>
             <?php
					$sql="select * from usuario where id=".$_GET["id"];
					$result=consultar($sql);
					while($row=mysql_fetch_assoc($result))
					{
				?>
				 
					    <form>
					    	<div style="display:none">
						    	<span><input name="opcion" id="opcion" type="text" class="textbox" placeholder="" value="actualizar"></span>
                                <span><input name="id" id="id" type="text" class="textbox" placeholder="" value="<?=$_GET["id"]?>"></span>
						    </div>
                            <div>
						    	<span><label>Usuario</label></span>
						    	<span><input name="usuario" id="usuario" type="text" class="textbox" placeholder="Usuario" value="<?=$row["usuario"]?>"></span>
						    </div>
                            <div>
						    	<span><label>Nombre</label></span>
						    	<span><input name="nombre" id="nombre" type="text" class="textbox" placeholder="Usuario" value="<?=$row["nombre"]?>"></span>
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
						   		<span><input type="submit" id="btnActualizar" class="" value="Actalizar"></span>
						  </div>
					    </form>
                        <?php
					}
				 ?>
				    </div>
                    <script type="text/javascript">
							$(document).ready(function(e) {
                                $("#btnActualizar").click(function(e) {
                                    e.preventDefault();
									//Variables
									var id=$("#id").val();
									var nombre=$("#nombre").val();
									var usuario=$("#usuario").val();
									var rol=$("#rol").val();
									$.ajax({
										url:"../php/opcionesUsuario.php",
										type:"POST",
										data:{
											"opcion":"actualizar",
											"id":id,
											"nombre":nombre,
											"usuario":usuario,
											"rol":rol
										},
										success: function(e)
										{
											if(e=="true")
											{
												alert("Usuario actualizado con exito!");
											}else{
												alert("Usuario no pudo ser actualizado");
											}
										}
									});
									
                                });
                            });
					</script>
  				<div class="clear"> </div>		
			  </div>
		</div>
</div>

<div class="footer_bg1">
<div class="wrap">
	
		<div class="clear"></div>
	</div>
</div>
</div>
</body>
</html>