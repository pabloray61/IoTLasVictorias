<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

$insertar = "ok";		//	INSERT
//$imprimir = "ok";		//	PRINT

// ------------------------------------------------------


if ($_REQUEST['borrar'] == "ok"){ // ------------------------------- MODIFICAR ---------------------------
	if($_REQUEST['tipo'] == "visita")$sql1 = "DELETE FROM visitas WHERE id_visita= ".$_REQUEST['id_visita'];
	if($_REQUEST['tipo'] == "llamado") $sql1 = "DELETE FROM llamados WHERE id_llamado= ".$_REQUEST['id_llamado'];
	if($insertar == "ok") query($sql1);
	if($imprimir == "ok") echo $sql1 . "<br>";
}
?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script language="javascript" src="calendar1.js"></script>
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


<table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr height="30"><td class="t">&nbsp;</td><td class="t" align="left">Listado de Seguimientos</td><td class="t">&nbsp;</td></tr>
	<tr height="20"><td colspan="3" class="c1"></td></tr>
	<tr height="30">
		<td class="c1">&nbsp;</td>
		<td class="c1">
			<form name="formu" action="<?= $_SERVER['PHP_SELF']."?".ahora()?>" method="post">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<?
						$buscar = $_REQUEST['buscar'];
						$fecha_desde = $_REQUEST['fecha_desde'];
						$fecha_hasta = $_REQUEST['fecha_hasta'];
						if($fecha_desde == ''){
							$mes = $_REQUEST['mes'];
							$ano = $_REQUEST['ano'];
						}
						
						if($buscar == "")$buscar = 1;
						?>
						<td class="c1">&nbsp;</td>
						<td class="c1" align="right">Filtro de seguimientos&nbsp;&nbsp;</td>
						<td class="c1">&nbsp;
							<select name="buscar" onChange="formu.submit();">
								<option value="1" <? if($buscar == 1){echo " SELECTED ";}?>>Mes en Curso</option>
								<option value="3" <? if($buscar == 3){echo " SELECTED ";}?>>Años / Meses</option>
								<option value="4" <? if($buscar == 4){echo " SELECTED ";}?>>Determinar Fecha</option>
							</select>
						</td>
						<td class="c1">&nbsp;</td>
						<?
						if($buscar == 1){
							$dias = date(d);
							$resta = -($dias-1);
						}
						if($buscar == 3){
							if($_REQUEST['ano'] == "") $ano = date(Y);
							if($_REQUEST['mes'] == "") $mes = date(m);
							$where = $_REQUEST['where'];
							?>
							<td class="c1" align="right">A&ntilde;o</td>
							<td class="c1">&nbsp;
								<select name="ano" onChange="javascript:formu.submit();">
									<option value="0">Todos</option>
									<?
									$hoy=getdate();
									for($a = 2000; $a <= $hoy['year']+1; $a++){
									?>
										<option <? if($ano == $a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
									<? }?>
								</select>
							</td>
							<td class="c1">&nbsp;</td>
							<td class="c1" align="right">Mes</td>
							<td class="c1">&nbsp;
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
							<td class="c1">&nbsp;</td>
						<?
						}
						if($buscar == 4){
						?>
							<td class="c1" width="40">Desde</td>
							<td class="c1" width="90"><input name="fecha_desde" type="text" size="10" value="<?= $fecha_desde?>"></td>
							<td class="c1" width="20"><img src="images/cal.gif" onClick="javascript:cal1.popup();">
							<td class="c1" width="30">&nbsp;</td>
							<td class="c1" width="40">Hasta</td>
							<td class="c1" width="90"><input name="fecha_hasta" type="text" size="10" value="<?= $fecha_hasta?>"></td>
							<td class="c1" width="20"><img src="images/cal.gif" onClick="javascript:cal12.popup();"></td>
							<td class="c1" width="50">&nbsp;</td>
							<td class="c1" width="20"><img src="images/b_search.png" onClick="formu.submit();"></td>
							<td class="c1" width="10">&nbsp;</td>
						<?
							list($dia_h, $mes_h, $ano_h) = split( '[/.-]', $fecha_hasta);
							$fecha_h = $ano_h."-".$mes_h."-".$dia_h;
							list($dia_d, $mes_d, $ano_d) = split( '[/.-]', $fecha_desde);
							$fecha_d = $ano_d."-".$mes_d."-".$dia_d;
						}
						?>
					</tr>
				</table>
			</form>
		</td>
		<td class="c1">&nbsp;</td>
	</tr>
</table>

<?
// RESTO DIAS -----------------
	function restarDias($numdias, $date) {
		if (isset($date)) {
			$date = time();
		}
		list($hora, $min, $seg, $dia, $mes_r, $anno) = explode( " ", date( "H i s d m Y"));
		$d = $dia + $numdias;
		$fecha = date("d-m-Y", mktime($hora, $min, $seg, $mes_r, $d, $anno));
		return $fecha;
	} 
// -----------------------------

if($buscar == 1){
	$ano = date(Y);
	$mes = date(m);
}

if($mes > 0){ 
	$mes_s = " month(fecha)=" . $mes;
	$fecha_d = '';
	$fecha_h = '';
}
if($ano > 0){ 
	$ano_s = "year(fecha)=" . $ano;
	$fecha_d = '';
	$fecha_h = '';
	if($mes > 0) $mes_s = $mes_s . " AND ";
	if($mes == 0) $ano_s = $ano_s;
}
if($fecha_d != "")	$f = " fecha >= '$fecha_d' AND fecha <= '$fecha_h'";
if($f == "--") $f = "";
		
?>

<table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr height="40">
		<td class="t" width="3%">&nbsp;</td>
		<td class="t" width="7%">&nbsp;</td>
		<td class="t" width="15%">Fecha</td>
		<? 	if($_SESSION['admin']=="ok"){?>
			<td class="t" width="34%">Cliente</td>
			<td class="t" width="28%" align="center">Vendedor</td>
		<? }else{?>
			<td class="t" width="62%" colspan="2">Cliente</td>
		<? }?>
		<td class="t" width="10">&nbsp;</td>
		<td class="t" width="3%">&nbsp;</td>
	</tr>
	<?
	if($_SESSION['admin']!="ok"){
		$vend=" AND vv.id_vendedor=". $_SESSION['id_vendedor'];
	}
	$a = date("Y");
	$m = date("m") - 1;
	if($m == 0) $m = 12;
	$d = date("d");
	$filtrar = $a."-".$m."-".$d;
	
	if($f != "" || $mes_s != "" || $ano_s != "" || $vend != "") $w = "WHERE";
	$where = $f." ".$mes_s." ".$ano_s." ".$vend;
	
	//echo("<br>W: ".$where." -|".substr($where, 0, 7)."|<br>");
	
	if(substr($where, 0, 7) == "    AND") $where = substr($where, 7, strlen($where));
	$where = $w." ".$where;
	
	$sql = "SELECT l.id_llamado AS id, 'l' AS tipo, l.id_vendedor, vv.nombre AS vendedor, l.id_cliente, cl.nombre, cl.apellido, l.fecha, l.observaciones FROM llamados l
			INNER JOIN clientes cl ON cl.id_cliente = l.id_cliente
			INNER JOIN vendedores vv ON vv.id_vendedor = l.id_vendedor
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
		<tr height="10"><td class="<?= $c?>" colspan="7"></td></tr>
		<tr height="40">
			<td class="<?= $c?>">&nbsp;</td>
			<td class="<?= $c?>" <? if($observaciones != "") echo("rowspan='2'")?>><img src="images/ico_<?= $ico?>.png" title="<?= $ico?>" border="0"></td>
			<td class="<?= $c?>"><? formatoFecha($rs['fecha'])?></td>
			<? 	if($_SESSION['admin']=="ok"){?>
				<td class="<?= $c?>"><?= $a?></td>
				<td class="<?= $c?>" align="center"><?= $vendedor?></td>
			<? }else{?>
				<td class="<?= $c?>" colspan="2"><?= $a?></td>
			<? }?>
			<td class="<?= $c?>" align="center">
				<? if($ico == "llamado"){?>
					<a href="abm_llamado.php?id_llamado=<?= $id?>&ver=modificar&buscar=<?= $buscar?>&mes=<?= $mes?>, ano=<?= $ano?>, fecha_d=<?= $fecha_d?>, fecha_h=<?= $fecha_h?>"><img src="images/b_save.png" border="0" alt="Editar el llamado"></a>&nbsp;&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?borrar=ok&tipo=llamado&id_llamado=<?= $id?>" onClick="return confirm('Estas seguro que queres eliminar el llamado a &#8220;<?= $a?>&#8221;?');"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar este llamado"></a>
				<? }else{?>
					<a href="abm_visita.php?id_visita=<?= $id?>&ver=modificar&buscar=<?= $buscar?>&mes=<?= $mes?>, ano=<?= $ano?>, fecha_d=<?= $fecha_d?>, fecha_h=<?= $fecha_h?>"><img src="images/b_save.png" border="0" alt="Editar la visita"></a>&nbsp;&nbsp;
					<a href="<?= $_SERVER['PHP_SELF']?>?borrar=ok&tipo=visita&id_visita=<?= $id?>" onClick="return confirm('Estas seguro que queres eliminar la visita a &#8220;<?= $a?>&#8221;?');"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar esta visita"></a>
				<? }?>
			</td>
			<td class="<?= $c?>" align="center"></td>
		</tr>
		<? if($observaciones != ""){?>
			<tr height="20">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>" colspan="4"><font style="font-weight:normal"><?= $observaciones?></font></td>
				<td class="<?= $c?>"></td>
			</tr>
			<tr height="10"><td class="<?= $c?>" colspan="7"></td></tr>
		<? }?>
	<? }?>
	<tr height="30">
		<td class="t">&nbsp;</td>
		<td class="t" colspan="3">Total de Seguimientos:&nbsp;<?= $t?></td>
		<td class="t" colspan="2" align="right">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="75%" align="right"><a href="imp_seguimientos.php?where=<?= $where?>" target="_blank" class="link_t"><img src="images/b_print.png" border="0"></a></td>
					<td width="25%" align="center"><a href="imp_seguimientos.php?where=<?= $where?>" target="_blank" class="link_t">Imprimir</a></td>
				</tr>
			</table>
		</td>
		<td class="t">&nbsp;</td>
	</tr>
</table>
<?
if($buscar == 4){
?>
<script language="javascript">
var cal1 = new calendar1(document.forms['formu'].elements['fecha_desde']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
</script>
<script language="javascript">
var cal12 = new calendar1(document.forms['formu'].elements['fecha_hasta']);
				call2.year_scroll = true;
				call2.time_comp = false;
</script>

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
