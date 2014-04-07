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
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="../web/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- start top_js_button -->
<script type="text/javascript" src="../web/js/jquery.min.js"></script>
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
<!--Scripts para el datagrid -->
<link rel="stylesheet" type="text/css" href="../js/simple.datagrid.css">
<script src="../js/simple.datagrid.js"></script>
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
				<li ><a href="subir.php">Crear Tabla</a></li>
				<li ><a href="archivos.php">Ver Tablas</a></li>
				<li class="active"><a href="reportes.php">Reportes</a></li>
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

<!-- start main -->
<div class="wrap">
	<div class="main">
	 	 	<table id="reportes"  width="100%" data-url="/datos/">
            <thead>
            <tr>
            	<th>Id</th>
                <th>Categoria</th>
                <th>Tabla</th>
                <th>Usuario</th>
                <th>Fecha</th>
                
            </tr>
            </thead>
            	
            </table>
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
				$(function() {
					<?php
					//Genero el codigo de cada fila
					$sql="select h.id as id, c.nombre as categoria, a.nombre as tabla, u.nombre as usuario, h.fecha as fecha  from historial h, usuario u, archivos a, categoria c where h.idUsuario=u.id and h.idArchivo=a.id and a.idCategoria=c.id";
					$result=consultar($sql);
					$html="";
					$json="";
					while($row=mysql_fetch_assoc($result))
					{
						if($json!="")
							$json.=",";
						/*$html.="<tr>";
						$html.="<td>".$row['id']."</td>";
						$html.="<td>".$row['nombrea']."</td>";
						$html.="<td>".$row['nombreu']."</td>";
						$html.="<td>".$row['fecha']."</td>";
						$html.="<tr>";*/
						$json.="{";
						$json.='"id":"'.$row['id'].'",';
						$json.='"categoria":"'.$row['categoria'].'",';
						$json.='"tabla":"'.$row['tabla'].'",';
						$json.='"usuario":"'.$row['usuario'].'",';
						$json.='"fecha":"'.$row['fecha'].'"';
						$json.="}";
					}
					//echo "var data=[".$json."];";
				
				?>
					

					ExampleData.handleMockjaxResponse = function(settings) {
						var page = settings.data.page || 1;
						var order_by = settings.data.order_by;
						var sortorder = settings.data.sortorder;
					
						var rows_per_page = 50;
						var start_index = (page - 1) * rows_per_page;
					
						var total_pages = 1;
						var data = ExampleData.datos;
						if (data.length != 0) {
							total_pages = parseInt((data.length - 1) / rows_per_page) + 1;
						}
					
						if (order_by) {
							data.sort(function(left, right) {
								var a = left[order_by];
								var b = right[order_by];
					
								if (sortorder == 'desc') {
									var c = b;
									b = a;
									a = c;
								}
					
								if (a < b) {
									return -1;
								}
								else if (a > b) {
									return 1;
								}
								else {
									return 0;
								}
							});
						}
					
						var result = {
							total_pages: total_pages,
							rows: data.slice(start_index, start_index + rows_per_page)
						};
						this.responseText = result;
					};
					ExampleData.datos=[<?=$json?>];
				  $.mockjax({
						url: '*',
						response: ExampleData.handleMockjaxResponse,
						responseTime: 0
					});
				  $('#reportes').simple_datagrid({
					  order_by:true
					});
				  /*$('#reportes').data({
					  'datagrid.select',
						  function(e) {
							// Row is selected
							console.log(e.row);
						  }
					});*/
					$('#reportes').bind(
					  'datagrid.select',
					  function(e) {
						// Row is selected
						console.log(e.row);
						var output='';
						$(location).attr("href","editar2.php?id="+e.row["id"]);
						for (var property in e.row) {
						  output += property + ': ' + e.row[property]+'; ';
						}
						console.log(output);
					  }
					);
					
					  
				});
				
			});
		</script>
		 <a href="../#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
		
	</div>
</div>
</div>
</body>
</html>