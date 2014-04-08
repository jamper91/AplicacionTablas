<?php
session_start();
include('../php/conectar.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>The Webworld-v2 Website Template | Contact :: w3layouts</title>
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
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(function(){
			  $('#Container').mixItUp();
			});
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
			$(".ser_btn1").click(function(e)
			{
				e.preventDefault();
				var idT=$(this).attr("idtabla");
				$.ajax({
					url:"borrarTabla.php",
					type:"POST",
					data:{
						"idtabla":idT
					},
					success: function(e2)
					{
						
						if(e2=="ok")
							$.notify("Archivo eliminado con exito","success");
						else
							$.notify("El archivo no pudo ser eliminado","error");
					}
					}).done(function()
					{
						location.reload();
					});
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
				<li class="active"><a href="archivos.php" >Crear Reporte</a></li>
				<li><a href="reportes.php">Reportes</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar Sesion</a></li>

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
		<!--  VALORES PARA LA BUSQUEDA  -->
			<?php if($_GET){  
				$val=$_GET["valor"]; 
				$fecha1=""; $fecha2=""; 

			}else{ $val="";  } 
			?>
		<div class="contact-form-">
			<form action="" method="get">
			
			
				<label>Buscar: </label><input type="text" id="valor" name="valor" class="" value="<?=$val?>" size="30" placeholder="palabra a Buscar">
				<select name="select">
					<option value ="categoria">Categoria</option>
					<option value ="tabla" selected>Tabla</option>
				
				</select>

				<input type="submit" Value="buscar">
			</form>

		</div>






    <div class="tabla2" >
	 	 	<table width="100%">
            <tr>
                <td>Categoria</td>
                <td>Tabla</td>
                <td>Usar</td>
                <!--<td>Eliminar</td>-->
            </tr>
            <?php
				//$sql="select * from categoria";



					// VALORES DEL POST
					//$valor=$_POST["valor"];
					//echo "VALOR=".$valor;
					$parametro="";
					if($_GET){
						$select=$_GET["select"];
						$buscar=$_GET["valor"];
						if($select){
							if($select=="tabla"){ $parametro=" AND a.nombre LIKE '%".$buscar."%'"; }
							//if($select=="version"){ $parametro=" AND h.version LIKE '%".$buscar."%'"; }
							if($select=="categoria"){ $parametro=" AND c.nombre LIKE '%".$buscar."%'"; }
							//if($select=="usuario"){ $parametro=" AND u.nombre LIKE '%".$buscar."%'"; }
						}else{
							$parametro="";
						}

						/*if($fecha1!=null && $fecha2!=null){
							$parametro=$parametro." AND (h.fecha >= '".$fecha1."' AND h.fecha<='".$fecha2."'   )";
						}*/


					}



				$sql="select a.id as id,a.nombre as nombre, c.nombre as categoria from archivos a, categoria c where  a.idCategoria=c.id  ".$parametro ;
				$result=consultar($sql);
				$html='';
				while($row=mysql_fetch_assoc($result))
				{
					//echo "entre";
					$html.="<tr>";
					$html.= '<td align="center">'.$row["categoria"].'</td>';
					$html.= '<td align="center">'.$row["nombre"].'</td>';
					$html.= '<td align="center"><a href="crear.php?id='.$row["id"].'">USAR</a></td>';
					//$html.= '<td align="center"><a href="#" onclick="eliminar('.$row["id"].')">Eliminar</a></td>';
					/*$html.= '<td><div class="ser_btn">
                    		<a class="button  ser_btn1" href="#" idtabla="'.$row["id"].'">Borrar</a>
						</div></td>';*/



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
				<!--  <div class="contact-form">
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
            </div> -->
         <!--   <script type="text/javascript">
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
								}else{
									alert("Categoria no pudo ser creada");
								}
							}
						});
						
					});
                });
			</script>-->
		</div>
</div>
<!--<div id="dialog-confirm" title="Eliminar usuario">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>La Categoria sera eliminado. Esta seguro?</p>
</div>-->
<div class="footer_bg1">
<div class="wrap">
	
</div>
</div>
</body>
</html>