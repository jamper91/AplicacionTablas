<?php
ini_set("memory_limit","1024M");
include 'excel_reader.php';     // include the class

// creates an object instance of the class, and read the excel file data
$excel = new PhpExcelReader;
$excel->read('preoperational.xls');

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
	$re='<form class="formEnviar" id="'.$nom.'" action="examples/exportar.php" method="post" >	<input type="textarea" id="txtHtml'.$nom.'" name="txtHtml"  style="display:none"/>	<INPUT type="submit" style="  background-image: url(\'http://c.dryicons.com/images/icon_sets/coquette_part_4_icons_set/png/128x128/pdf_file.png\');background-size: contain;  width: 80px;  height: 80px;   background-color: #FFFFFF;  border: medium none;"> </form><div id="contenedor'.$nom.'" class="TablaAzul">
			';
  $re .= '<table id="example'.$nom.'"  border="1" cellspacing="3" cellpadding="4" >';     // starts html table

  $x = 1;
  while($x <= $sheet['numRows']) {
    $re .= "<tr>\n";
    $y = 1;
    while($y <= $sheet['numCols']) {
      $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
	  $cellInfo =	isset($sheet['cellsInfo'][$x][$y]['colspan']) ? $sheet['cellsInfo'][$x][$y]['colspan'] : null;					
		  if($cell=="Monday"){
			$pintarC=false;
			$posicionC=array();
			$posC=0;
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
	   $cols=1;
	   if($cellInfo!=null)
	   {
			$cols=$cellInfo;
	   }
	   if($x>$filC && in_array($y,$posicionC))
	   {
			$re.="<td><input type='checkbox'> <img src='images/check.png' border=0 width='24' height='24' style='display:none' /></td>";
	   }else{
			if($cols>1){
				$re .= " <td colspan='$cols' align='center'><input type='text' value='$cell' style='display:none;' size='2' /><label>$cell</label></td>\n";  
				$y+=$cols-1;
				}else
			$re .= " <td><input type='text' value='$cell' style='display:none;' size='2' /><label>$cell</label></td>\n";  
	   }
			
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
<title>The Webworld-v2 Website Template | About :: w3layouts</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="web/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- start top_js_button -->
<!--<script type="text/javascript" src="web/js/jquery.min.js"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="web/js/move-top.js"></script>
<script type="text/javascript" src="web/js/easing.js"></script>
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
			<a href="index.html"><img src="web/images/logo.png" alt=""/> </a>
		</div>
		<div class="social-icons">
		    <ul>
		      <li><a href="#" target="_blank"></a></li>
			  <li><a href="#" target="_blank"></a></li>
		      <li><a href="#" target="_blank"></a></li>
			  <li><a href="#" target="_blank"></a></li>
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
				<li class="active"><a href="index.html">Home</a></li>
				<li><a href="about.html">About us</a></li>
				<li><a href="service.html">Service</a></li>
				<li><a href="index.html">Pages</a></li>
				<li><a href="blog.html">Blog</a></li>
				<li><a href="contact.html">Contact us</a></li>
			</ul>
		</div>
		<div class="h_search">
    		<form>
    			<input type="text" value="" placeholder="search something...">
    			<input type="submit" value="">
    		</form>
		</div>
        <div class="menu">
        	<ul>
				<li class="active"><a href="index.html">Home</a></li>
				<li><a href="about.html">About us</a></li>
				<li><a href="service.html">Service</a></li>
				<li><a href="index.html">Pages</a></li>
				<li><a href="blog.html">Blog</a></li>
				<li><a href="contact.html">Contact us</a></li>
            </ul>
        </div>
        <div class="search">
            <form action="/iphone/search.html">
                <input type="text" value="Search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Search';}" class="text">
            </form>
        </div>
        <div class="sub-head">
        	<ul>
            	<li><a href="#" id="menu">Menu  <span></span></a></li>
            	<li><a href="#" id="search">Search <span></span></a></li>
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
	<script type="text/javascript" src="web/js/script.js"></script>
	<div class="clear"></div>

		<div class="clear"></div>
</div>
</div>
</div>
<!-- start top_bg -->
<div class="top_bg">
<div class="wrap">
	<div class="top">
		<h2>about us</h2>
 	</div>
</div>
</div>
<!-- start main -->
<div class="wrap">
		<div  id="tabs">
			<?php
			// displays tables with excel file data
			echo $pestanas;
			echo $tabs;
			?>   
		
		
		</div>
	       <form id="enviar" action="examples/exportar.php" method="post" >
			<input type="textarea" id="txtHtml" name="txtHtml"  style="display:none"/>
			<INPUT type="submit" value="Exportar">

			</form>
			<div id="contenedor" class="TablaAzul">
			    
			</div>
		
		<div class="clear"></div>
		<script>
		  $(function() {
			$( "#tabs" ).tabs();
		  });
		  </script>
</div>
<!-- start footer -->
<div class="footer_bg">
<div class="wrap">
	<div class="footer">
		<!-- start span_of_4 -->
		<div class="span_of_4">
			<div class="span1_of_4">
				<h4>popular post</h4>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				<ul class="f_nav1">
					<li class="timer"><a href="#">25-september 2013 </a></li>
				</ul>
				<p class="top">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				<ul class="f_nav1">
					<li class="timer"><a href="#">25-september 2013 </a></li>
				</ul>
			</div>
			<div class="span1_of_4">
				<h4>tags</h4>
				<p>It is a long established fact that a reader will be distracted by the<big>readable</big> content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal <big>blog</big> Many desktop publishing packages and web page editors now use Lorem.</p>
			</div>
			<div class="span1_of_4">
				<h4>a little about us</h4>
				<p class="btm">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
				<p>It is a long established fact that a reader will be of a page when looking at its layout.</p>

			</div>
			<div class="span1_of_4">
				<h4>get in touch</h4>
				<p class="btm">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since</p>
				<p class="btm1 pin">Texas, US</p>
				<p class="btm1 mail"><a href="mailto:info@mycompany.com">info(at)mycompany.com </a></p>
				<p class="call">01234 444 777</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<!-- start footer -->
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
		 <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
		<!--end scroll_top_btn -->
		<div class="social-icons">
		    <ul>
		      <li><a href="#" target="_blank"></a></li>
			  <li><a href="#" target="_blank"></a></li>
		      <li><a href="#" target="_blank"></a></li>
			  <li><a href="#" target="_blank"></a></li>
			</ul>
		</div>
		<div class="copy">
			<p class="link"><span>&copy; 2014 Webworld-v2. All rights reserved | Template by&nbsp;<a href="http://w3layouts.com/"> W3Layouts</a></span></p>
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
<script type="text/javascript">
 
$(document).ready(function(){
     
	 //Busco los checks que se hayan seleccionado y los cambio por una imagen
		$(".TablaAzul :checkbox").click(function()
		{
			$(this).parent().html('1');
			//$(this).css('display','none');
			//$(this).next().css('display','block');
			//$(this).parent().html($(this).parent().html()+"<img src='images/check.png' style='display:none' />");
		});
		
	 /*$('#enviar').submit(function()
	 {
		//Elimino todos los inputs	
		$("#example input[type='text']").remove();
		//Elimino todos los checkbox
			$("#example :checkbox").remove();
		//Tomo el codigo html
		var html=$("#contenedor").html();
		$('#txtHtml').val(html);
		
	 });*/
	 $('.formEnviar').submit(function()
	 {
		//Elimino todos los inputs	
		$("#example input[type='text']").remove();
		//Elimino todos los checkbox
			$("#example :checkbox").remove();
		//Tomo el codigo html
		//alert($(this).attr('id'));
		var html=$("#contenedor"+$(this).attr('id')).html();
		$('#txtHtml'+$(this).attr('id')).val(html);
		
	 });
	 $('.TablaAzul td').click(function()
	 {	
		//Oculto todos los otros elementos
		$('.TablaAzul input[type="text"]').each(function()
		{
			$(this).css('display','none');
		});
		$('.TablaAzul label').each(function()
		{
			$(this).css('display','block');
		});
		$(this).find('input[type="text"]').css('display','block');
		$(this).find('label').css('display','none');
		$(this).find('input[type="text"]').focus();
	 });
	 $('.TablaAzul input[type="text"]').change(function()
	 {
		$(this).next().text($(this).val());
	 });
});
</script>
</body>
</html>