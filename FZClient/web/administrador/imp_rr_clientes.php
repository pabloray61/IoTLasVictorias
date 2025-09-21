<? require("conn.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}
?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style></head>

<body>

<table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr><td align="center"><img src="images/logo.jpg"></td></tr>
	<tr height="10"><td></td></tr>
	<tr height="20"><td class="titulo" align="center"><b>ACORDES - RESUMEN - CLIENTES</b></td></tr>
	<tr height="10"><td class="data" align="center">Fecha de impresion: <?= date(d."-".m."-".Y)?></td></tr>
	<tr height="20"><td></td></tr>
</table>
<?
	$id_p = $_REQUEST['id_p'];
	$id_tipo = $_REQUEST['id_tipo'];
	$id_categoria = $_REQUEST['id_categoria'];
	$id_v = $_REQUEST['id_v'];
	
	if($id_tipo != "" OR $id_categoria != "" OR $id_v != "") $w = "WHERE ";
	if($id_tipo != "") $id_t = "c.id_tipo= ".$id_tipo. " AND ";
	if($id_categoria != "") $id_c = "c.id_categoria= ".$id_categoria. " AND ";
	if($id_v != "") $id_ve = "c.id_vendedor= ".$id_v. " AND ";
	$where = $w ."". $id_t ."". $id_c ."". $id_ve;
	$where = substr($where, 0, strlen($where) - 5);

$anos = array();
$i = 0;
$a = query("SELECT year(fecha) AS ano FROM ventas WHERE year(fecha) <> '' GROUP BY ano DESC LIMIT 6");
while($rs = mysql_fetch_array($a)){
	$anos[$i] = $rs['ano'];
	$i++;
}
$anos = array_reverse($anos); 
?>

<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="encabezado" width="30%">&nbsp;&nbsp;Cliente</td>
		<td class="encabezado" width="10%" align="center">Catg</td>
		<td class="encabezado" width="10%" align="center">Vend</td>
			<? foreach($anos as $ano){ ?>
				<td class="encabezado" width="5%" align="center"><?= $ano?></td>
			<? }?>
		<td class="encabezado" width="10%" align="center">TOTAL</td>
	</tr>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<?	
	$qc = query("SELECT c.id_cliente, c.apellido, c.nombre, cc.sigla AS sigla_cat, ve.sigla AS sigla_vend 
				FROM clientes c
				INNER JOIN ventas v ON v.id_cliente = c.id_cliente
				LEFT JOIN vendedores ve ON ve.id_vendedor = c.id_vendedor
				LEFT JOIN categoria_clientes cc ON cc.id_categoria = c.id_categoria
				$where
				GROUP BY c.id_cliente ORDER BY apellido, nombre");
	$c_T = 0;
	if($id_p == 1) $andP = "AND presentacion LIKE '%caja%'";
	if($id_p == 2) $andP = "AND presentacion LIKE '%botella%'";
	if($id_p == 3) $andP = "AND presentacion NOT LIKE '%caja%' AND presentacion NOT LIKE '%botella%'";
	while($rc = mysql_fetch_array($qc)){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		
		$id_cliente = $rc['id_cliente'];
		$cliente = $rc['apellido'];
		$nombre = $rc['nombre'];
		if($nombre != "") $cliente = $cliente.", ".$nombre;
		$categoria = $rc['sigla_cat'];
		$vendedor = $rc['sigla_vend'];
		?>
		<tr height="30">
			<td class="data">&nbsp;&nbsp;<?= $cliente?></td>
			<td class="data" align="center"><?= $categoria?></td>
			<td class="data" align="center"><?= $vendedor?></td>
			<? 
			$a = 0;	
			$c_T = 0;
			foreach($anos as $ano){
				$sql = "SELECT SUM(vd.cant) AS cant, SUM(vd.cant * p.ue) AS cant_eq FROM ventas_detalle vd
						INNER JOIN ventas v ON v.id_venta = vd.id_venta
						LEFT JOIN productos p ON p.id_producto = vd.id_producto
						LEFT JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE YEAR(v.fecha) = $ano AND v.id_cliente= $id_cliente $andP";
				//echo ($sql."<br><br>");
				$q = query($sql);
				$rs = mysql_fetch_array($q);
				$cant = $rs['cant'];
				if($id_p == 9) $cant = $rs['cant_eq'];
				if($cant == "") $cant = 0;
				?><td class="data" align="center"><?= number_format($cant, 0, ',','.')?></td><? 
				$c_T += $cant;
				$ano_T[$a] += $cant;
				$total += $cant;
				$a++;
				?>
			<? }?>
			<td class="data" align="center"><?= number_format($c_T, 0, ',','.')?></td>
		</tr>
		<? 
		$reg ++;
	}
	?>
	<tr height="2" bgcolor="#000000"><td colspan="14"></td></tr>
	<tr height="30">
		<td class="encabezado">&nbsp;&nbsp;TOTAL: &nbsp;&nbsp;<?= $reg?> Registros</td>
		<td class="encabezado" colspan="2">&nbsp;</td>
		<? 	
		$a = 0;
		foreach($anos as $ano){?>
			<td class="encabezado" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
			<? $a++;?>
		<? }?>
		<td class="encabezado" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>




</body>
</html>
