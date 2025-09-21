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
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<table height="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top" width="100%">
	
<p align="center" class="titulo">Registro de llamados y visitas</p>
		<table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr height="40">
				<td class="encabezado" width="3%">&nbsp;</td>
				<td class="encabezado" width="7%">&nbsp;</td>
				<td class="encabezado" width="15%">Fecha</td>
				<? 	if($_SESSION['admin']=="ok"){?>
					<td class="encabezado" width="34%">Cliente</td>
					<td class="encabezado" width="28%" align="center">Vendedor</td>
				<? }else{?>
					<td class="encabezado" width="62%" colspan="2">Cliente</td>
				<? }?>
				<td class="encabezado" width="10">&nbsp;</td>
				<td class="encabezado" width="3%">&nbsp;</td>
			</tr>
			<tr height="1"><td colspan="7" bgcolor="#333333"></td></tr>
			<?
			
			$where = $_REQUEST['where'];
			
			$sql = "SELECT l.id_llamado AS id, 'l' AS tipo, l.id_vendedor, vl.nombre AS vendedor, l.id_cliente, cl.nombre, cl.apellido, l.fecha, l.observaciones FROM llamados l
					INNER JOIN clientes cl ON cl.id_cliente = l.id_cliente
					INNER JOIN vendedores vl ON vl.id_vendedor = l.id_vendedor
					$where
					UNION 
					SELECT v.id_visita AS id, 'v' AS tipo, v.id_vendedor, vv.nombre AS vendedor, v.id_cliente, cv.nombre, cv.apellido, v.fecha, v.observaciones FROM visitas v
					INNER JOIN clientes cv ON cv.id_cliente = v.id_cliente
					INNER JOIN vendedores vv ON vv.id_vendedor = v.id_vendedor
					$where
					ORDER BY fecha DESC";
			//echo $sql."<br><br>";
			$q = query($sql);
			$t = 0;
			while($rs=mysql_fetch_array($q)){
				$t++;
				$id = $rs['id'];
				$tipo = $rs['tipo'];
				if($tipo == "v") $ico = "visita";
				if($tipo == "l") $ico = "llamado";
				$id_vendedor = $rs['id_vendedor'];
				$vendedor = $rs['vendedor'];
				$id_cliente = $rs['id_cliente'];
				$n = $rs['nombre'];
				$a = $rs['apellido'];
				if($n != "") $a = $a.", ".$n;
				
				$fecha = $rs['fecha'];
				$observaciones = "";
				$observaciones = $rs['observaciones'];
		
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				?>  
				<tr height="40">
					<td class="dataBold">&nbsp;</td>
					<td class="dataBold" rowspan="2"><img src="images/ico_<?= $ico?>.png" title="<?= $ico?>" border="0"></td>
					<td class="dataBold"><? formatoFecha($rs['fecha'])?></td>
					<? 	if($_SESSION['admin']=="ok"){?>
						<td class="dataBold"><?= $a?></td>
						<td class="dataBold" align="center"><?= $vendedor?></td>
					<? }else{?>
						<td class="dataBold" colspan="2"><?= $a?></td>
					<? }?>
					<td class="dataBold" align="center">&nbsp;</td>
					<td class="dataBold" align="center"></td>
				</tr>
				<? if($observaciones != ""){?>
					<tr height="20">
						<td class="data">&nbsp;</td>
						<td class="data" colspan="4"><font style="font-weight:normal"><?= $observaciones?></font></td>
						<td class="data"></td>
					</tr>
					<tr height="10"><td class="data" colspan="7"></td></tr>
				<? }?>
				<tr height="1"><td colspan="7" bgcolor="#333333"></td></tr>
			<? }?>
			<tr height="30">
				<td class="encabezado">&nbsp;</td>
				<td class="encabezado" colspan="5" align="right">Total de Seguimientos:&nbsp;<?= $t?></td>
				<td class="encabezado">&nbsp;</td>
			</tr>
		</table>


	  </td>
	</tr>
</table>
</body>
</html>
