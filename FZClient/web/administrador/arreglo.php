<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?
require("conn.php");
require("func.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<?
$sql = "SELECT c.apellido, c.nombre, v.fecha, v.factura, v.dto_fijo, v.dto_porc, vd.id_producto, vd.cant, vd.precio, vd.precio_final, 
		(SELECT precio FROM precios p WHERE p.id_lista = l.id_lista AND p.id_producto = vd.id_producto ORDER BY fecha DESC LIMIT 1) AS PL 
		FROM ventas v 
		INNER JOIN ventas_detalle vd ON vd.id_venta = v.id_venta
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente
		INNER JOIN listas l ON l.id_lista = c.id_lista
		WHERE v.factura = 1 AND v.fecha > '2010-01-01' AND vd.precio != 0
		ORDER BY fecha ASC, v.id_venta";

$result = query($sql);

$count = mysql_num_fields($result);

echo("<table width='90%' border='1' align='center' cellpadding='0' cellspacing='0' style='border:thin, #666'>");
echo("<tr height='30'>");
$a = array();
for ($i = 0; $i < $count; $i++){
	$t = mysql_field_type($result, $i);
	$t == "string" ? $a[$i] = "left" : $a[$i] = "center";
	echo("<td align='".$a[$i]."'><b>".mysql_field_name($result, $i)."</b></td>\t");
}
echo("<td align='center'><b>PN</b></td>\t");
echo("<td align='center'><b>PFN</b></td>\t");
echo("</tr>");

$x = 1;
while($row = mysql_fetch_row($result)){
	echo("<tr height='20'>");
	foreach($row as $value){
		if(!isset($value) || $value == ""){
			echo("<td>&nbsp;</td>\t");
		}else{
			echo("<td align='".$a[$x]."'>".$value."</td>\t");
		}
		if($x == 10) $pn = $value * 1.21;
		if($x == 11) $pfn = $value * 1.21;
		if($x == 11) $x = 0;
		$x++;
	}
	echo("<td align='center'>$pn</td>\t");
	echo("<td align='center'>$pfn</td>\t");
	echo("</tr>");
	$pn = "";
	$pfn = "";
}
echo("</table>");
?>

</body>
</html>