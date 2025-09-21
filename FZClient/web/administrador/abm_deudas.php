<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");


if($_SESSION['admin'] == "ok"){
	$id_v = $_REQUEST['id_v'];
}else{
	$id_v = $_SESSION['id_vendedor'];
}


$id_cliente = $_REQUEST['id_cliente'];

?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->

<!-- InstanceEndEditable -->

<link rel="stylesheet" href="includes/menu.css" type="text/css">
<script type="text/javascript" src="includes/jquery143.js"></script>
<script type='text/javascript' src='includes/menu.js'></script>

<script type="text/javascript" src="js/stmenu.js"></script>
<script type="text/javascript">
<!--
window.onerror=function(m,u,l)
{
	window.status = "Java Script Error: "+m;
	return true;
}
//-->
</script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>


<? 
	if($_SESSION['admin'] == "ok") $admin = 1;
	
	$vendedor = $_SESSION['nombre_vend'];
	$exp = explode(",", $vendedor);
	if($exp[1] == ""){
		$n = $exp[0];
	}else{
		$n = $exp[1];
	}
	
	include("_menu.php");
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="121" valign="top">
				<table width="100%" height="121" border="0" cellpadding="0" cellspacing="0" id="HEADER">
					<tr>
						<td width="343" valign="top" class="header-left3">
						  <img src="images/headers/mm-ap.jpg" width="341" height="80">
						  <p class="textToolBar">&nbsp;&nbsp;&nbsp;&nbsp;Bienvenido <?= $n?></p>
						</td>
						<td class="expand3">&nbsp;</td>
						<td width="358" valign="top" class="header-right3">
							<p>&nbsp;<br><br><br></p><p>&nbsp;</p>
					    	<p align="right"><a href="logout.php" class="textToolBarLink">Log out</a>&nbsp;&nbsp;&nbsp;</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		  <td height="15"><div align="right"></div></td>
		</tr>	
		<tr valign="top">
			<td height="5">
			  <!-- InstanceBeginEditable name="SubMenu" -->
			
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- InstanceBeginEditable name="body" -->

<?
if($_SESSION['admin'] == "ok"){
?>
<p align="center" class="titulo">&nbsp;</p>
<p align="center" class="titulo">Elegir un vendedor</p>
<p align="center">
<form name="formul" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<select name="id_v" onChange="formul.submit();">
		<option>Seleccione vendedor</option>
		<?
		$q = query("SELECT * FROM vendedores ORDER BY nombre");
		while($rs=mysql_fetch_array($q)){
		?>
			<option value="<?=$rs['id_vendedor']?>" <?  if($id_v == $rs['id_vendedor']){ echo "SELECTED";} ?>><?=$rs['nombre']?></option>
		<? }?>
	</select>
</form>
</p>	
<? } 
if($id_v > 0){?>
<p align="center" class="titulo">Elegir un cliente </p>
<p align="center">
<form name="formu" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="id_v" value="<?= $id_v?>">
	<select name="id_cliente" onChange="formu.submit();">
		<option>Seleccione un cliente</option>
		<option></option>		
		<option value="todos"<?  if($id_cliente == "todos"){ echo "SELECTED";} ?>>Ver todos los clientes</option>
		<option></option>
		<? 
		if($id_v != 1) $q = query("SELECT * FROM clientes WHERE id_vendedor = ".$id_v." ORDER BY apellido, nombre");
		if($id_v == 1) $q = query("SELECT * FROM clientes ORDER BY apellido, nombre");
		
		while($rs=mysql_fetch_array($q)){
			$nombre = $rs['apellido'];
			$n = $rs['nombre'];
			if($n != "") $nombre = $nombre.", ".$n;
		?>
			<option value="<?=$rs['id_cliente']?>" <?  if($id_cliente == $rs['id_cliente']){ echo "SELECTED";} ?>><?= $nombre?></option>
		<? }?>
	</select>
</form>
</p>
<?
}
	
if ($id_cliente > 0 && id_cliente != "todos"){

$sql = "SELECT saldo,
		SUM(- case WHEN  (select sum(monto) from pagos where id_venta = v.id_venta) > 0 
			THEN (select sum(monto) from pagos where id_venta=v.id_venta) 
			ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
		FROM ventas v INNER JOIN clientes c on v.id_cliente = c.id_cliente
		WHERE c.id_cliente = $id_cliente AND ISNULL(v.incobrable)
		GROUP BY c.id_cliente";
$q = query($sql);
$rs = mysql_fetch_array($q);
$saldo = $rs['saldo'];

?>
<table width="500" align="center" cellpadding="0" cellspacing="0">
	<tr height="30">
    	<td class="t" width="5%">&nbsp;</td>
		<td class="t" width="60%">Saldo a favor del cliente</td>
		<td class="t" width="30%" align="right">$&nbsp;<?= number_format($saldo, 0, ',', '.')?></td>
    	<td class="t" width="5%">&nbsp;</td>
	</tr>
	<tr height="30">
		<td class="t">&nbsp;</td>	
		<td class="t">Saldo deudor del cliente</td>
		<td class="t" align="right">$&nbsp;<?= number_format($rs['deuda'], 0, ',', '.')?></td>
		<td class="t">&nbsp;</td>		
  </tr>
</table>
<br>


<br>
<p class="titulo" align="center">Listado de ventas sin cancelar totalmente</p>

<?
$lado = $_REQUEST['lado'];		
$oa = $_REQUEST['oa'];
$ob = $_REQUEST['ob'];
$op = $_REQUEST['op'];
if($oa != $op) $lado = "DESC";
if($lado == "DESC"){
	$lado = "ASC";
}else{
	$lado = "DESC";
}
if($oa == "" && $lado == "DESC") $lado = "ASC";
if($oa == "") $oa = "fecha";
if($ob == "") $ob = "monto";
$orden = "ORDER BY ".$oa." ".$lado.", ".$ob." ".$lado;
?>

<table width="700" align="center" cellpadding="0" cellspacing="0">
	<tr height="30">
		<td width="30%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_cliente=<?= $id_cliente?>&id_v=<?= $id_v?>&oa=fecha&ob=monto&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por fecha" class="link_t">Fecha</a></td>
		<td width="20%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_cliente=<?= $id_cliente?>&id_v=<?= $id_v?>&oa=cajas&ob=fecha&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cajas" class="link_t">Cajas</a></td>
		<td width="30%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_cliente=<?= $id_cliente?>&id_v=<?= $id_v?>&oa=monto&ob=fecha&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por monto" class="link_t">Monto</a></td>
		<td width="20%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_cliente=<?= $id_cliente?>&id_v=<?= $id_v?>&oa=acancelar&ob=fecha&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por a cancelar" class="link_t">A cancelar</a></td>
	</tr>
	<?
	$k=0; // k lo usopara contar cada pago
	if($_SESSION['admin'] != "ok") $qv = "AND v.id_vendedor=". $id_v;
	
	$sql = "SELECT id_venta, fecha, clientes.id_cliente, nombre, apellido,
			(SELECT SUM(cant * precio_final) FROM ventas_detalle vd WHERE vd.id_venta = v.id_venta AND regalo != 1) AS monto, 
			ROUND(((SELECT SUM(cant * precio) FROM ventas_detalle vd WHERE vd.id_venta = v.id_venta AND regalo != 1)*(1-dto_porc/100) - dto_fijo)*100)/100 AS monto_sd, 
			(SELECT SUM(cant) FROM ventas_detalle vd WHERE vd.id_venta = v.id_venta) AS cajas, 
			((SELECT SUM(cant * precio_final) FROM ventas_detalle vd WHERE vd.id_venta = v.id_venta) - (SELECT SUM(monto) FROM pagos WHERE id_venta = v.id_venta)) AS falta, 
			ROUND((((SELECT SUM(cant * precio) FROM ventas_detalle vd WHERE vd.id_venta = v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 - (SELECT SUM(monto) FROM pagos WHERE id_venta = v.id_venta)) AS falta_sd, 
			v.id_vendedor FROM ventas v 
		INNER JOIN clientes on clientes.id_cliente = v.id_cliente 
		WHERE clientes.id_cliente = $id_cliente AND ISNULL(v.incobrable) $qv
		ORDER BY fecha DESC";
		
	//echo ($sql."<br><br>");	
	$q = query($sql);

	$i=0;
	while($rs = mysql_fetch_array($q)){
		if(is_null($rs['falta_sd']) AND is_null($rs['falta'])){
			$falta = $rs['monto'];
			if($rs['monto'] == "") $falta = $rs['monto_sd'];
		}else{
			$falta = $rs['falta'];
			if($falta == "") $falta = $rs['falta_sd'];
		}
		$falta_T += $falta;
		$cajas = $rs['cajas'];
		$cajas_T += $cajas;
		$monto = $rs['monto'];
		if($monto == "") $monto = $rs['monto_sd'];
		$monto_T += $monto;
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		if($falta == 0) $c = "cv";
		?>  
		<tr height="25">
			<td class="<?= $c?>" align="center"><?= rotarFecha($rs['fecha'])?></td>
			<td class="<?= $c?>" align="center"><?= number_format($cajas, 0, ',', '.')?></td>
			<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($monto, 0, ',', '.')?></td>
			<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($falta, 0, ',', '.')?></td>
		</tr>
		<?
		$q2=query("SELECT * FROM pagos INNER JOIN modo_pago mp ON mp.id_modo_pago=pagos.id_modo_pago WHERE id_venta=" . $rs['id_venta']);
		while($rs2=mysql_fetch_array($q2)){
			$monto_p = $rs2['monto'];
			?>
			<tr height="20">
				<td class="<?= $c?>" align="center"><?= rotarFecha($rs2['fecha'])?></td>
				<td class="<?= $c?>" align="center"><?=$rs2['modo']?></td>
				<td class="<?= $c?>" align="center">$<?= number_format($monto_p, 0, ',', '.')?></td>
				<td class="<?= $c?>" align="center">&nbsp;</td>
			</tr>
			<?
			$k++;
		}
		$i++;
		?>
			<tr height="1"><td colspan="4"></td></tr>
		<?
	}
	?>
	<tr height="25">
		<td class="t" align="center">&nbsp;</td>
		<td class="t" align="center"><?= number_format($cajas_T, 0, ',', '.')?></td>
		<td class="t" align="center">$&nbsp;<?= number_format($monto_T, 0, ',', '.')?></td>
		<td class="t" align="center">$&nbsp;<?= number_format($falta_T, 0, ',', '.')?></td>
	</tr>
</table>

<?
} // end if id_cliente

if ($id_cliente == "todos"){
?>
<p class="titulo" align="center">DEUDA PENDIENTE</p>	

<p class="titulo" align="center">
	<a href="imp_deuda_todos.php?tipo=vendedores" target="_blank"><img src="images/b_print.png" border="0">Imprimir Deuda x Vendedores</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="imp_deuda_todos.php?tipo=clientes" target="_blank"><img src="images/b_print.png" border="0">Imprimir Deuda x tipo de Cliente</a>
</p>

<table align="center" width="98%"  cellspacing="0" cellpadding="0">
  <tr class="encabezado" bgcolor="#efebdf" height="30">
    <td width="33%">Cliente</td>
    <td width="10%" align="center">Vend.</td>
    <td width="13%" align="right">Deuda</td>
    <td width="10%" align="right">&lt;30 d</td>
    <td width="10%" align="right">30-60</td>
    <td width="10%" align="right">&gt;60 d </td>
    <td width="11%" align="right">&nbsp;</td>
  </tr>
 
<?
if($_SESSION['admin'] != "ok"){
	$w = "v.id_vendedor = $id_v AND ";
}else{
	if($id_v > 1) $w = "v.id_vendedor = $id_v AND ";
}
//deuda vendedor
$sql="select c.id_cliente, c.nombre, c.apellido, s.nombre AS vendedor, s.sigla,

SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha >= curdate() - interval 30 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 30dias,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() - interval 30 day and v.fecha >= curdate()-interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 3060dias ,
SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta and v.fecha < curdate() -  interval 60 day )*(1-dto_porc/100) - dto_fijo)*100)/100) as 60dias 

FROM ventas v 
INNER JOIN clientes c on v.id_cliente=c.id_cliente
INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
WHERE $w - case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 >0
GROUP BY c.id_cliente, c.nombre
ORDER BY s.sigla, apellido, nombre asc";

if($_SESSION['admin'] == "ok" && $id_v < 2 && $id_cliente == "todos"){
	$sql="select c.id_cliente, c.nombre, c.apellido, s.nombre AS vendedor, s.sigla,

	SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
	
	FROM ventas v 
	INNER JOIN clientes c on v.id_cliente=c.id_cliente
	INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
	WHERE $w - case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 >0
	GROUP BY c.id_cliente, c.nombre
	ORDER BY s.sigla, apellido, nombre asc";
}

//echo("$sql<br><br>");
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
			<td colspan="2">&nbsp;&nbsp;Deuda Total de <?= $vend?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="7"></td></tr>
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
		<form method="post" action="<?=$_SERVER['PHP_SELF']?>"> 
		  <tr class="data" height="30">
			<td><?=$nombre?></td>
			<td align="center"><?= $rs['sigla']?></td>
			<td><div align="right">$<?=number_format($rs['deuda'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['30dias'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['3060dias'],0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($rs['60dias'],0,',','.')?></div></td>
			<td align="right"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?= $rs['id_cliente']?>&id_vendedor=<?= $id_v?>"><img src="images/b_ver.png" border="0"></a></td>
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
			<td colspan="2">&nbsp;&nbsp;Deuda Total de <?= $vend?></td>
			<td><div align="right">$<?=number_format($deuda_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda30_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda3060_v,0,',','.')?></div></td>
			<td><div align="right">$<?=number_format($deuda60_v,0,',','.')?></div></td>
			<td align="right">&nbsp;</td>
		  </tr>		
		  <tr height="15"><td colspan="7"></td></tr>
		<?
		$deuda_v = 0;
		$deuda30_v = 0;
		$deuda3060_v = 0;
		$deuda60_v = 0;		
	}
?>

  <tr bgcolor="#efebdf" height="30">
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



			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td vAlign="bottom"></td>
		</tr>
		<tr><td vAlign="top" height="30"></td></tr>
		<tr>
			<td height="44" align="center" valign="bottom">
				<table class="pie" id="FOOTER" height="44" cellSpacing="0" cellPadding="0" width="100%" border="0">
					<tr>
						<td align="center">© 2009 ACORDES SA - Todos los derechos reservados</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>			


</body>
<!-- InstanceEnd --></html>
