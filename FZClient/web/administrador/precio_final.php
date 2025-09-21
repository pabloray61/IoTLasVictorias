<?
require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
</head>

<body>

<?
$q = query("SELECT * FROM ventas");
while($rs = mysql_fetch_array($q)){
	$id_venta = $rs['id_venta'];
	$dto_fijo = $rs['dto_fijo'];
	$dto_porc = $rs['dto_porc'];
	$q2 = query("SELECT * FROM ventas_detalle WHERE id_venta = $id_venta")
	while($rs2 = mysql_fetch_array($q2)){
		
	}
}
?>



</body>
</html>
