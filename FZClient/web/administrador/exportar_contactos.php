<?
require("conn.php");
require("func.php");

session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

$filtro_v = $_REQUEST['filtro_v'];
$filtro_c = $_REQUEST['filtro_c'];
$filtro_t = $_REQUEST['filtro_t'];

$vend = "";
if($_SESSION['admin'] != "ok"){
	$vend= " id_vendedor=" . $_SESSION['id_vendedor'];
}else{
	if($filtro_v != "" AND $filtro_v != "all"){ 
		$vend = " v.id_vendedor = " . $filtro_v;
	}
}			
if($filtro_t != "" and $filtro_t != "all") $tipo = " t.id_tipo = ".$filtro_t;
if($filtro_c != "" and $filtro_c != "all") $categoria = " c.id_categoria = ".$filtro_c;

if($vend != "" || $tipo != "" || $categoria != "") $w = " WHERE";
if($vend != "" && ($tipo != "" || $categoria != "")) $w2 = " and";
if($tipo != "" && $categoria != "") $w3 = " and";

$where = $w ." ". $vend ." ". $w2 ." ". $tipo ." ". $w3 ." ". $categoria ." ". $sq2 ." ". $orden;

   	$sql="SELECT  
			CASE poe WHEN '1' THEN 'Persona' WHEN '2' THEN 'Empresa' ELSE '' END AS Tipo,
			c.apellido AS Apellido, c.nombre AS nombre,
			CASE sexo WHEN '1' THEN 'M' WHEN '2' THEN 'F' ELSE '' END AS Sexo, 
			c.fecha_cumple AS Cumpleaños, dni AS DNI, cuit AS CUIT,
			c.telefono AS Telefono, c.celular AS Celular, c.mail AS Mail, c.contacto AS Contacto,
			c.direccion AS Direccion, c.localidad AS Localidad, c.cp AS CP,
			c.fecha_alta AS Alta, c.referente AS Referente, cc.categoria AS Categoria, t.tipo AS Cliente, l.lista AS Lista,
			g.grupo AS Grupo, v.nombre AS Vendedor
			FROM clientes c 
			LEFT JOIN categoria_clientes cc ON c.id_categoria = cc.id_categoria 
			LEFT JOIN tipo_clientes t ON c.id_tipo = t.id_tipo 
			LEFT JOIN listas l ON c.id_lista = l.id_lista
			LEFT JOIN grupos g ON c.id_grupo = g.id_grupo
			LEFT JOIN vendedores v ON c.id_vendedor = v.id_vendedor
			$where
			";
	$result = query($sql);
	
	$count = mysql_num_fields($result);

	for ($i = 0; $i < $count; $i++){
    	$header .= mysql_field_name($result, $i)."\t";
	}

	while($row = mysql_fetch_row($result)){
 	 	$line = '';
  		foreach($row as $value){
    		if(!isset($value) || $value == ""){
      			$value = "\t";
    		}else{
				# important to escape any quotes to preserve them in the data.
      			$value = str_replace('"', '""', $value);
				# needed to encapsulate data in quotes because some data might be multi line.
				# the good news is that numbers remain numbers in Excel even though quoted.
      			$value = '"' . $value . '"' . "\t";
    		}
    		$line .= $value;
 	 	}
  		$data .= trim($line)."\n";
	}

	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
  	$data = str_replace("\r", "", $data);

	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
  		$data = "\nNo se encontró ningun cliente\n";
	}

	# This line will stream the file to the user rather than spray it across the screen
	header("Content-type: application/octet-stream");

	# replace excelfile.xls with whatever you want the filename to default to
	$hoy = date(d."-".m."-".Y);
	header("Content-Disposition: attachment; filename=Clientes-$hoy.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo $header."\n".$data;
	
	?>