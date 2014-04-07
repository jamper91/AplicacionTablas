<?php
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
function sheetData($sheet) {
  
  //Variable para saber si pinto checkbox
$pintarC=False;
//VAraible para saber las posiciones donde se pintara el checbox
$posicionC=array();
$posC=0;
$filC=0;
  $re = '<table id="example" border="1" cellspacing="3" cellpadding="4">';     // starts html table

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
			$re.="<td><input type='checkbox'></td>";
	   }else{
			if($cols>1){
				$re .= " <td colspan='$cols'><input type='text' value='$cell' style='display:none;' size='2' /><label>$cell</label></td>\n";  
				$y+=$cols-1;
				}else
			$re .= " <td><input type='text' value='$cell' style='display:none;' size='2' /><label>$cell</label></td>\n";  
	   }
			
      $y++;
    }  
    $re .= "</tr>\n";
    $x++;
  }

  return $re .'</table>';     // ends and returns the html table
}

$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet

// traverses the number of sheets and sets html table with each sheet data in $excel_data
for($i=0; $i<1; $i++) {
  $excel_data .= '<h4>Sheet '. ($i + 1) .' (<em>'. $excel->boundsheets[$i]['name'] .'</em>)</h4>'. sheetData($excel->sheets[$i]) .'<br/>';  
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Example PHP Excel Reader</title>
<script type="text/javascript" src="js/jquery.js"></script>

</head>
<body>
<form id="enviar" action="examples/exportar.php" method="post" >
<input type="textarea" id="txtHtml" name="txtHtml"  style="display:none"/>
<INPUT type="buttom" id="btnExportar" value="Exportar2">
<INPUT type="submit" value="Exportar">

</form>
<div id="contenedor">
<?php
// displays tables with excel file data
echo $excel_data;
?>    
</div>

<script type="text/javascript">
	/* 
 * Example init
 */
 function exportar()
 {
	
	
 }
 
$(document).ready(function(){
     
	 //Busco los checks que se hayan seleccionado y los cambio por una imagen
		$("#example :checkbox").click(function()
		{
			
			$(this).parent().html('1');
			
		});
	 $("#btnExportar").click(function ()
	 {
	 $("#example td:first").trigger("click",function()
	 {
		//Elimino todos los inputs	
		$("#example input[type='text']").remove();
		//Elimino todos los checkbox
			$("#example :checkbox").remove();
			//Tomo el codigo html
			var html=$("#contenedor").html();
			$('#txtHtml').val(html);
		alert('hola');
	 });
		
	 });
	 $('#enviar').submit(function()
	 {
		//Elimino todos los inputs	
		$("#example input[type='text']").remove();
		//Elimino todos los checkbox
			$("#example :checkbox").remove();
		//Tomo el codigo html
		var html=$("#contenedor").html();
		$('#txtHtml').val(html);
		
	 });
	 $('#example td').click(function()
	 {
		console.log("ente td");
		//Oculto todos los otros elementos
		$('#example input[type="text"]').each(function()
		{
			$(this).css('display','none');
		});
		//Oculto todos los otros elementos
		$('#example label').each(function()
		{
			$(this).css('display','block');
		});
		
		$(this).find('input').css('display','block');
		$(this).find('label').css('display','none');
		$(this).find('input').focus();
	 });
	 $('#example input[type="text"]').change(function()
	 {
		$(this).next().text($(this).val());
	 });
});
</script>
</body>
</html>
