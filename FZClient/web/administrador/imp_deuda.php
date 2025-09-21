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

<br>
<table align="center" cellpadding="0" cellspacing="0">
	<tr><td class="titulo" align="center">Deuda Pendiente - <?= $_SESSION['nombre_vend']?></td></tr>
	<tr><td class="data" align="center"><?= date(d."-".m."-".Y)?></td></tr>
</table>
<br>

<table align="center" width="98%"  cellspacing="2" cellpadding="2">
  <tr class="encabezado">
    <td width="30%">Cliente</td>
    <td width="16%" align="right">Deuda</td>
    <td width="15%" align="right">&lt;30 d</td>
    <td width="13%" align="right">30 - 60 d</td>
    <td width="15%" align="right">&gt;60 d </td>
    <td width="11%" align="right">&nbsp;</td>
  </tr>
 
<?
//deuda vendedor
$sql="select c.id_cliente, c.nombre, c.apellido, 
(select sum(vd.cant) from ventas_detalle vd inner join productos p on p.id_producto=vd.id_producto  where p.id_linea>99  and p.id_linea < 300 and vd.id_venta=v.id_venta and 
 case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta) > 0 then (select sum(monto) from pagos where id_venta=v.id_venta) else 0 end < round(( (select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as cajas,

SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha >= curdate() - interval 30 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 30dias,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() - interval 30 day and v.fecha >= curdate()-interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 3060dias ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() -  interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 60dias 

FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id_cliente
WHERE - case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 >0 AND v.id_vendedor=".$_SESSION['id_vendedor']."
GROUP BY c.id_cliente, c.nombre
ORDER BY apellido, nombre asc";
$q=query($sql);

$deuda_tot=0;
$deuda30=0;
$deuda3060=0;
$deuda60=0;

while($rs=mysql_fetch_array($q)){
$deuda_tot += $rs['deuda'];
$deuda30 += $rs['30dias'];
$deuda3060 += $rs['3060dias'];
$deuda60 += $rs['60dias'];

$nombre = $rs['apellido'];
$n = $rs['nombre'];
if($n != "") $nombre = $nombre.", ".$n;
?> 
<form method="post" action="<?=$_SERVER['PHP_SELF']?>"> 
  <tr class="data">
    <td><?=$nombre?></td>
    <td><div align="right">$
                  <?=number_format($rs['deuda'],0,',','.')?>
    </div></td>
    <td><div align="right">$
                  <?=number_format($rs['30dias'],0,',','.')?>
    </div></td>
    <td><div align="right">$
                  <?=number_format($rs['3060dias'],0,',','.')?>
    </div></td>
    <td class="data"><div align="right">$
          <?=number_format($rs['60dias'],0,',','.')?>
    </div></td>
    <td align="right"></td>
  </tr>
  </form>
  <?
  
  }?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="encabezado">Total</td>
    <td align="right" class="encabezado">$<?=number_format($deuda_tot,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda30,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda3060,0,',','.')?></td>
    <td align="right" class="encabezado">$<?=number_format($deuda60,0,',','.')?></td>
    <td>&nbsp;</td>
  </tr>
</table>



</body>
</html>
