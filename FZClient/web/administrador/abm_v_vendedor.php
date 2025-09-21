<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($mes == "" && $ano == "") $ano = date("Y");
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

<p align="center" class="titulo">Ventas totales por Vendedor </p>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="formu">
	<table align="center" width="200" cellspacing="2" cellpadding="2">
		<tr>
			<td width="73" class="encabezado">A&ntilde;o</td>
			<td width="111">
				<select name="ano" onChange="javascript:formu.submit();">
					<option value=""></option>
					<?
					$hoy = getdate();
					for($a = 2000; $a <= $hoy['year']+1; $a++){
					?>
					<option <? if($ano==$a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
					<? }?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="encabezado">Mes</td>
			<td>
				<select name="mes" onChange="javascript:formu.submit();">
					<option value="0">Todos</option>
					<option <? if($mes=="1") {echo " SELECTED";} ?> value="1">Enero</option>
					<option <? if($mes=="2") {echo " SELECTED";} ?> value="2">Febrero</option>
					<option <? if($mes=="3") {echo " SELECTED";} ?> value="3">Marzo</option>
					<option <? if($mes=="4") {echo " SELECTED";} ?> value="4">Abril</option>
					<option <? if($mes=="5") {echo " SELECTED";} ?> value="5">Mayo</option>
					<option <? if($mes=="6") {echo " SELECTED";} ?> value="6">Junio</option>
					<option <? if($mes=="7") {echo " SELECTED";} ?> value="7">Julio</option>
					<option <? if($mes=="8") {echo " SELECTED";} ?> value="8">Agosto</option>
					<option <? if($mes=="9") {echo " SELECTED";} ?> value="9">Septiembre</option>
					<option <? if($mes=="10") {echo " SELECTED";} ?> value="10">Octubre</option>
					<option <? if($mes=="11") {echo " SELECTED";} ?> value="11">Noviembre</option>
					<option <? if($mes=="12") {echo " SELECTED";} ?> value="12">Diciembre</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<br>
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
if($oa == "") $oa = "apellido";
if($ob == "") $ob = "monto";
$orden = "ORDER BY ".$oa." ".$lado.", ".$ob." ".$lado;

?>	
<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="4%">&nbsp;</td>
		<td class="t" width="40%"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=nombre&ob=monto&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por vendedor" class="link_t">Vendedor</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=botellas&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas" class="link_t">Botellas</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=botellasV&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas vendidas" class="link_t">BV</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=botellasB&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas bonificadas" class="link_t">BB</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cajas&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas" class="link_t">Cajas</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cajasV&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas vendidas" class="link_t">CV</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cajasB&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas bonificadas" class="link_t">CB</a></td>
		<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cant_eq&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad Equivalentes" class="link_t">Cant Eq.</a></td>
		<td class="t" width="10%" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=monto&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Monto" class="link_t">Monto</a></td>
		<td class="t" width="4%">&nbsp;</td>
	</tr>
  <?
$where = "";
if($_SESSION['admin']!="ok"){
	$where="WHERE v.id_vendedor=" . $_SESSION['id_vendedor'] . "  and";
} else{
	$where =" WHERE";
}
if($mes > 0){ $where = $where . " month(fecha)=" . $mes . "   and";}
if($ano > 0){ $where = $where . " year(fecha)=" . $ano. "   and";}

$where = substr($where,0,strlen($where)-5);

$sql = "SELECT vend.id_vendedor, vend.nombre, 
		((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd,
		((SUM(vd.precio * p.ue * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_eq_sd,
		SUM(CASE WHEN regalo != 1 THEN vd.precio_final * vd.cant ELSE 0 END) AS monto,
		SUM(vd.precio_final * p.ue * vd.cant) AS monto_eq,
		SUM(cant * ue) AS cant_eq,
		SUM( CASE WHEN pp.unidades = 1 THEN vd.cant ELSE 0 END ) AS botellas, 
		SUM( CASE WHEN pp.unidades = 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS botellasV, 
		SUM( CASE WHEN pp.unidades = 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS botellasB, 
		SUM( CASE WHEN pp.unidades > 1 THEN vd.cant ELSE 0 END ) AS cajas,
		SUM( CASE WHEN pp.unidades > 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS cajasV, 
		SUM( CASE WHEN pp.unidades > 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS cajasB 
		FROM ventas v 
		INNER JOIN vendedores vend on v.id_vendedor= vend.id_vendedor
		INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta
		INNER JOIN productos p on p.id_producto = vd.id_producto
		INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
		" . $where . "
		GROUP BY vend.id_vendedor, vend.nombre
		ORDER BY vend.nombre";

//echo($sql."<br>");
$q = query($sql);

	$cajas = 0;
	$monto = 0;
	$botellas = 0;
	$monto = 0;
	
while($rs=mysql_fetch_array($q)){
	$cajas = $rs['cajas'];
	$cajasV = $rs['cajasV'];
	$cajasB = $rs['cajasB'];
	$cajas_T += $cajas;
	$cajas_TV += $cajasV;
	$cajas_TB += $cajasB;
	$botellas = $rs['botellas'];
	$botellasV = $rs['botellasV'];
	$botellasB = $rs['botellasB'];
	$botellas_T += $botellas;
	$botellas_TV += $botellasV;
	$botellas_TB += $botellasB;
	$cant_eq = $rs['cant_eq'];
	$cant_eq_T += $cant_eq;
	$monto = $rs['monto'];
	if($monto == "") $monto = $rs['monto_sd'];
	$monto_T += $monto;

	$c = $flag ? "c1":"c2";
	$flag = !$flag;
	?>
	<tr height="30">
		<td class="<?= $c?>">&nbsp;</td>
		<td class="<?= $c?>" style="border-right-style:solid; border-right-color:#333333;"><?= $rs['nombre']?></td>
		<td align="center" class="<?= $c?>"><?= number_format($botellas,0,',','.')?></td>
		<td align="center" class="<?= $c?>"><?= number_format($botellasV,0,',','.')?></td>
		<td align="center" class="<?= $c?>" style="border-right-style:solid; border-right-color:#333333;"><?= number_format($botellasB,0,',','.')?></td>
		<td align="center" class="<?= $c?>"><?= number_format($cajas,0,',','.')?></td>
		<td align="center" class="<?= $c?>"><?= number_format($cajasV,0,',','.')?></td>
		<td align="center" class="<?= $c?>" style="border-right-style:solid; border-right-color:#333333;"><?= number_format($cajasB,0,',','.')?></td>
		<td align="center" class="<?= $c?>"><?= number_format($cant_eq,0,',','.')?></td>
		<td align="right" class="<?= $c?>">$&nbsp;<?= number_format($monto,2,',','.')?></td>
		<td class="<?= $c?>">&nbsp;</td>
	</tr>
	<?
}
?>
	<tr height="40">
		<td class="t">&nbsp;</td>
		<td class="t">Total</td>
		<td class="t" align="center"><?= number_format($botellas_T,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($botellas_TV,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($botellas_TB,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($cajas_T,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($cajas_TV,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($cajas_TB,0,',','.')?></td>
		<td class="t" align="center"><?= number_format($cant_eq_T,0,',','.')?></td>
		<td class="t" align="right">$&nbsp;<?= number_format($monto_T,2,',','.')?></td>
		<td class="t">&nbsp;</td>
	</tr>
</table>



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
