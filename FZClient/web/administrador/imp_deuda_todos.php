<?
require("conn.php");
require("func.php");
session_start();
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}


$tipo = $_REQUEST['tipo'];
?>
<html>
<head>
<title>ACORDES .::. Selected Brands .::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="stylesheet" type="text/css">
</head>

<body>

<br>

<?
if ($tipo == "vendedores"){
?>
<table align="center" cellpadding="0" cellspacing="0">
	<tr><td class="titulo" align="center">Deuda Pendiente por vendedores</td></tr>
	<tr><td class="data" align="center"><?= date(d."-".m."-".Y)?></td></tr>
</table>
<br>
<table align="center" width="800"  cellspacing="0" cellpadding="0">
  <tr class="encabezado" bgcolor="#efebdf" height="30">
  	<td width="2%">&nbsp;</td>
    <td width="33%">Cliente</td>
    <td width="10%" align="center">Vend.</td>
    <td width="14%" align="right">Deuda</td>
    <td width="12%" align="right">&lt;30 d</td>
    <td width="12%" align="right">30-60</td>
    <td width="12%" align="right">&gt;60 d </td>
    <td width="2%" align="right">&nbsp;</td>
  </tr>
 
<?
//deuda vendedor
$sql="select c.id_cliente, c.nombre, c.apellido, s.nombre AS vendedor, s.sigla,
(select sum(vd.cant) from ventas_detalle vd inner join productos p on p.id_producto=vd.id_producto  where p.id_linea>99  and p.id_linea < 300 and vd.id_venta=v.id_venta and 
 case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta) > 0 then (select sum(monto) from pagos where id_venta=v.id_venta) else 0 end < round(( (select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as cajas,

SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha >= curdate() - interval 30 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 30dias,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() - interval 30 day and v.fecha >= curdate()-interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 3060dias ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() -  interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 60dias 

FROM ventas v 
INNER JOIN clientes c on v.id_cliente=c.id_cliente
INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
WHERE - case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 >0
GROUP BY c.id_cliente, c.nombre
ORDER BY s.sigla, apellido, nombre asc";

$q = query($sql);

$deuda_tot=0;
$deuda30=0;
$deuda3060=0;
$deuda60=0;
  	
while($rs=mysql_fetch_array($q)){
	$deuda_tot += $rs['deuda'];
	$deuda30 += $rs['30dias'];
	$deuda3060 += $rs['3060dias'];
	$deuda60 += $rs['60dias'];
	
  	$sa = $rs['sigla'];  
	if($sa != $sd && $sd != ""){ 	
		?>
		  <tr class="encabezado" bgcolor="#efebdf" height="30">
		  	<td>&nbsp;</td>
			<td colspan="2">Deuda Total de <?= $vend?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="8"></td></tr>
		<?
		$deuda_v = 0;
		$deuda30_v = 0;
		$deuda3060_v = 0;
		$deuda60_v = 0;		
	}

	$deuda_v += $rs['deuda'];
	$deuda30_v += $rs['30dias'];
	$deuda3060_v += $rs['3060dias'];
	$deuda60_v += $rs['60dias'];	
	if($rs['deuda'] > 1){
		$nombre = $rs['apellido'];
		$n = $rs['nombre'];
		if($n != "") $nombre = $nombre.", ".$n;
		?> 
		  <tr class="data" height="20">
		  	<td>&nbsp;</td>
			<td><?=$nombre?></td>
			<td align="center"><?= $rs['sigla']?></td>
			<td><div align="right">$<?=number_format($rs['deuda'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['30dias'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['3060dias'],0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($rs['60dias'],0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>
	  <?
	} // IF deuda > 0
	
	$sd = $rs['sigla'];
	$vend = $rs['vendedor'];
	$nom = substr(strstr($vend, ", "), 2, strlen(strstr($vend, ", "))-2) ;
	$ap = substr($vend, 0, (strlen($vend) - strlen($nom) - 2));
	$vend = $nom. " ". $ap;	
}
	if($deuda_v != ""){ 	
		?>
		  <tr class="encabezado" bgcolor="#efebdf" height="30">
		  	<td>&nbsp;</td>
			<td colspan="2">Deuda Total de <?= $vend?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="8"></td></tr>
		<?
		$deuda_v = 0;
		$deuda30_v = 0;
		$deuda3060_v = 0;
		$deuda60_v = 0;		
	}
?>

  <tr bgcolor="#efebdf" height="30">
	<td>&nbsp;</td>
    <td class="encabezado">Total</td>
	<td>&nbsp;</td>
    <td align="right" class="encabezado">$<?=number_format($deuda_tot,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda30,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda3060,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda60,0,',','.')?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<? }?>

<?
if ($tipo == "clientes"){
?>
<table align="center" cellpadding="0" cellspacing="0">
	<tr><td class="titulo" align="center">Deuda pendiente por tipo de cliente</td></tr>
	<tr><td class="data" align="center"><?= date(d."-".m."-".Y)?></td></tr>
</table>
<br>
<table align="center" width="800"  cellspacing="0" cellpadding="0">
  <tr class="encabezado" bgcolor="#efebdf" height="30">
  	<td width="2%">&nbsp;</td>
    <td width="33%">Cliente</td>
    <td width="10%" align="center">&nbsp;</td>
    <td width="14%" align="right">Deuda</td>
    <td width="12%" align="right">&lt;30 d</td>
    <td width="12%" align="right">30-60</td>
    <td width="12%" align="right">&gt;60 d </td>
    <td width="2%" align="right">&nbsp;</td>
  </tr>
 
<?
//deuda vendedor
$sql="select c.id_cliente, c.nombre, c.apellido, c.id_tipo, t.tipo,
(select sum(vd.cant) from ventas_detalle vd inner join productos p on p.id_producto=vd.id_producto  where p.id_linea>99  and p.id_linea < 300 and vd.id_venta=v.id_venta and 
 case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta) > 0 then (select sum(monto) from pagos where id_venta=v.id_venta) else 0 end < round(( (select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as cajas,

SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha >= curdate() - interval 30 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 30dias,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() - interval 30 day and v.fecha >= curdate()-interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 3060dias ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() -  interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 60dias 

FROM ventas v 
INNER JOIN clientes c on v.id_cliente=c.id_cliente
INNER JOIN tipos t on t.id_tipo = c.id_tipo 
WHERE - case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 >0
GROUP BY c.id_cliente, c.nombre
ORDER BY apellido, nombre, t.tipo asc";

$q = query($sql);

$deuda_tot=0;
$deuda30=0;
$deuda3060=0;
$deuda60=0;

while($rs=mysql_fetch_array($q)){
	$deuda_tot += $rs['deuda'];
	$deuda30 += $rs['30dias'];
	$deuda3060 += $rs['3060dias'];
	$deuda60 += $rs['60dias'];
	
  	$sa = $rs['tipo'];  
	if($sa != $sd && $sd != ""){ 	
		?>
		  <tr class="encabezado" bgcolor="#efebdf" height="30">
		  	<td>&nbsp;</td>
			<td colspan="2">Deuda Total de <?= $tipo?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="8"></td></tr>
		<?
		$deuda_v = 0;
		$deuda30_v = 0;
		$deuda3060_v = 0;
		$deuda60_v = 0;		
	}

	$deuda_v += $rs['deuda'];
	$deuda30_v += $rs['30dias'];
	$deuda3060_v += $rs['3060dias'];
	$deuda60_v += $rs['60dias'];	
	if($rs['deuda'] > 1){
		$nombre = $rs['apellido'];
		$n = $rs['nombre'];
		if($n != "") $nombre = $nombre.", ".$n;
		?> 
		  <tr class="data" height="20">
		  	<td>&nbsp;</td>
			<td><?=$nombre?></td>
			<td align="center">&nbsp;</td>
			<td><div align="right">$<?=number_format($rs['deuda'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['30dias'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['3060dias'],0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($rs['60dias'],0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>
	  <?
	} // IF deuda > 0
	
	$sd = $rs['tipo'];
	$tipo = $rs['tipo'];
}
	if($deuda_v != ""){ 	
		?>
		  <tr class="encabezado" bgcolor="#efebdf" height="30">
		  	<td>&nbsp;</td>
			<td colspan="2">Deuda Total de <?= $tipo?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td class="data"><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="8"></td></tr>
		<?
		$deuda_v = 0;
		$deuda30_v = 0;
		$deuda3060_v = 0;
		$deuda60_v = 0;		
	}
?>

  <tr bgcolor="#efebdf" height="30">
	<td>&nbsp;</td>
    <td class="encabezado">Total</td>
	<td>&nbsp;</td>
    <td align="right" class="encabezado">$<?=number_format($deuda_tot,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda30,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda3060,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda60,0,',','.')?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<? }?>

</body>
</html>
