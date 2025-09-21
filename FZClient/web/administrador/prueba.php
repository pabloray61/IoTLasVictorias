<?
require("conn.php");
require("func.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
		<title>DataTables example</title>
		<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table_jui.css";
			@import "css/jquery-ui-1.7.2.custom.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );
		</script>
	</head>
	<body id="dt_example">
		<div id="container">
			<div class="demo_jui">
<? if($a){?>            
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<td>Rendering engine</td>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>
		</tr>
	</thead>
	<tbody>
		<tr class="gradeX">
			<td>Trident</td>
			<td>Internet
				 Explorer 4.0</td>
			<td>Win 95+</td>
			<td class="center">4</td>
			<td class="center">X</td>
		</tr>
     </tbody>
</table>
<? }?>
<?
$sql = "SELECT id_cliente, apellido, nombre, ";
for($i = 2004; $i <= date("Y"); $i++){
	$sql .=" (SELECT SUM( CASE WHEN unidades > 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS cajas
			FROM ventas v 
			INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta
			INNER JOIN productos p ON p.id_producto = vd.id_producto
			INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
			WHERE YEAR(fecha) = '$i' AND v.id_cliente = clientes.id_cliente) AS '$i',";
}
$sql .="mail FROM clientes $where ORDER BY apellido, nombre LIMIT 50";
//echo("$sql<br>");
?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th>Cliente</th>
			<? for($i = 2004; $i <= date("Y"); $i++){?>
	            <th><?= $i?></th>
			<? }?>
		</tr>
	</thead>
	<tbody>
	    <?
		$q = query($sql);
		while($rs = mysql_fetch_array($q)){
			$nombre = $rs['apellido'];
			$n = $rs['nombre'];
			$cant = $rs[$i];
			if($cant == "") $cant = 0;
			if($n != "") $nombre = $nombre.", ".$n;
			?>
			<tr class="gradeA">
				<td><?= $nombre?></td>
				<? for($i = 2004; $i <= date("Y"); $i++){?>
                    <td align="center"><?= $cant?></td>
                <? }?>
			</tr>
		<? }?>
	</tbody>
</table>

			</div>
		</div>
	</body>
</html>