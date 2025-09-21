<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$buscar = $_REQUEST['buscar'];
$op = $_REQUEST['op'];
$id_v = $_REQUEST['id_v'];
$id_categoria = $_REQUEST['id_categoria'];
$id_grupo = $_REQUEST['id_grupo'];

$fecha_desde = $_REQUEST['fecha_desde'];
$fecha_hasta = $_REQUEST['fecha_hasta'];
if($fecha_desde == ''){
	$mes = $_REQUEST['mes'];
	$ano = $_REQUEST['ano'];
}

if($buscar == "")$buscar = 1;
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

<p class="titulo" align="center">Reporte de Actividad</p>
<br>

<table width="900" align="center" cellpadding="3" cellspacing="1" border="0">
<form name="formu" action="<?= $_SERVER['PHP_SELF']."?".ahora()?>" method="post">
	  <tr>
        <td colspan="1">&nbsp;</td>
        <td colspan="1" class="encabezado">Operacion</td>
        <td colspan="7">
			<select name="op" onChange="formu.submit();">
				<option value="">Todas</option>
				<option value="1" <? if($op == 1){echo " SELECTED ";}?>>Venta</option>
				<option value="2" <? if($op == 2){echo " SELECTED ";}?>>Visita</option>
				<option value="3" <? if($op == 3){echo " SELECTED ";}?>>Llamado</option>
				<option value="4" <? if($op == 4){echo " SELECTED ";}?>>Cobranza</option>
				<? if($_SESSION['admin']=="ok"){?>
					<option value="5" <? if($op == 5){echo " SELECTED ";}?>>Produccion</option>
					<option value="6" <? if($op == 6){echo " SELECTED ";}?>>Transferencia</option>
				<? }?>
			</select>
		</td>
	  </tr>
      <tr>
        <td colspan="1">&nbsp;</td>
        <td colspan="1" class="encabezado">Clientes</td>
        <td colspan="7">
			<select name="id_categoria" onChange="javascript:formu.submit();">
				<option value="">Todos</option>
				  <?
				  $q = query("SELECT * FROM categoria_clientes");
				  while ($rs = mysql_fetch_array($q)){
				  ?>
					<option value="<?=$rs['id_categoria']?>" <? if ($_REQUEST['id_categoria'] == $rs['id_categoria']){echo " SELECTED";} ?>><?=$rs['categoria']?>	</option>
				  <? }?>	
			</select>
		</td>
      </tr>
		<? if($_SESSION['admin']=="ok"){?>
          <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="1" class="encabezado">Vendedor</td>
            <td colspan="7">
                <select name="id_v" onChange="javascript:formu.submit();">
                    <option value="">Todos</option>
                    <?
                    $q = query("SELECT * FROM vendedores WHERE activo = 1 ORDER BY nombre");
                    while($rs=mysql_fetch_array($q)){
                    ?>
                    <option value="<?=$rs['id_vendedor']?>" <? if ($_REQUEST['id_v']==$rs['id_vendedor']){echo " SELECTED";} ?>><?=$rs['nombre']?></option>
                    <? }?>
                </select>
            </td>
          </tr>
        <? }?>
        <tr>
	        <td colspan="1">&nbsp;</td>
			<td class="encabezado">Grupo</td>
			<td colspan="7">
            <? $q = query("SELECT * FROM grupos ORDER BY grupo");?>
			<select name="id_grupo" onChange="javascript:formu.submit();">
				<option value="">Todos</option>
				  <? while ($rs = mysql_fetch_array($q)){?>
					<option value="<?=$rs['id_grupo']?>" <? if ($_REQUEST['id_grupo'] == $rs['id_grupo']){echo " SELECTED";} ?>><?=$rs['grupo']?></option>
				  <? }?>	
			</select>
			</td>
		</tr>
  	  <tr>
        <td colspan="1">&nbsp;</td>
        <td colspan="1" class="encabezado">Fecha</td>
        <td colspan="7">
			<select name="buscar" onChange="formu.submit();">
				<option value="1" <? if($buscar == 1){echo " SELECTED ";}?>>Mes en Curso</option>
				<option value="3" <? if($buscar == 3){echo " SELECTED ";}?>>Años / Meses</option>
				<option value="4" <? if($buscar == 4){echo " SELECTED ";}?>>Determinar Fecha</option>
			</select>&nbsp;&nbsp;
		</td>
	  </tr>
  <tr><td colspan="9">&nbsp;</td></tr>
<?
if($buscar == 1){
	$dias = date(d);
	$resta = -($dias-1);
}
//if($buscar == 2)
if($buscar == 3){
?>
  <tr>
	<td>&nbsp;</td>
	<td class="encabezado">A&ntilde;o</td>
	<td colspan="7"><select name="ano" onChange="javascript:formu.submit();">

	<option value=""></option>
	<?
	$hoy=getdate();
	for($a = 2000; $a <= $hoy['year']+1; $a++){
	?>
	<option <? if($ano==$a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
	<?
	}
	?>
	</select></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="encabezado">Mes</td>
	<td colspan="7">
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
<?
}
if($buscar == 4){
?>
  <tr><td colspan="9">&nbsp;</td></tr>
  <tr class="data">
	<td colspan="9" align="center">Desde&nbsp;&nbsp;
		<input name="fecha_desde" type="text" size="10" value="<?= $fecha_desde?>">&nbsp;
		<img src="images/cal.gif" onClick="javascript:cal1.popup();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Hasta&nbsp;&nbsp;
		<input name="fecha_hasta" type="text" size="10" value="<?= $fecha_hasta?>">&nbsp;
		<img src="images/cal.gif" onClick="javascript:cal12.popup();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="images/b_search.png" onClick="formu.submit();">
	</td>
  </tr>
  <tr><td colspan="9">&nbsp;</td></tr>
<?
	list($dia_h, $mes_h, $ano_h) = split( '[/.-]', $fecha_hasta);
	$fecha_h = $ano_h."-".$mes_h."-".$dia_h;
	list($dia_d, $mes_d, $ano_d) = split( '[/.-]', $fecha_desde);
	$fecha_d = $ano_d."-".$mes_d."-".$dia_d;
}
?>
</form>

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

if($fecha_h == "" && $mes == 0 && $ano == 0){
	$mes = date(m);
	$ano = date(Y);
}

$lado = $_REQUEST['lado'];
$orden = $_REQUEST['orden'];

if($orden == ""){
	$orden = "fecha";
	$lado = "ASC";
}

if($lado == "ASC"){
	$lado = "DESC";
}
else{
	$lado = "ASC";
}

$ord = "ORDER BY $orden $lado";

if($_SESSION['admin']!="ok"){
	$vend1 = " && v.id_vendedor=". $_SESSION['id_vendedor'];
	$vend2 = " && p.id_vendedor=". $_SESSION['id_vendedor'];
}
if($_SESSION['admin']=="ok"){
	$vend3 = " && pr.id_produccion = 0";
	$vend4 = " && t.id_transferencia = 0";
}
$c_c_v_T = $c_b_v_T = $c_p_p_T = $c_c_p_T = $c_b_p_T = $c_p_p_T = $c_c_o_T = $c_b_o_T = $c_p_o_T = 0;
$reg_v = $reg_p = $reg_o = 0;
$monto_v_T = $monto_p_T = $monto_o_T = 0;

if($op != "") $f_op = "&& operacion =". $op;
if($id_v != "" && $op != 4) $f_id_v = "&& v.id_vendedor =". $id_v;
if($id_v != "" && $op != 4) $f_id_v2 = "&& c.id_vendedor =". $id_v;
if($id_v != "" && $op == 4) $f_id_v = "&& c.id_vendedor =". $id_v;
if($id_categoria != "") $f_id_categoria = "&& id_categoria =". $id_categoria;
if($id_grupo != "") $f_id_grupo = "&& g.id_grupo=" . $id_grupo;

if($mes > 0){ 
	$mes_s = " month(fecha)=" . $mes;
	$fecha_d = '';
	$fecha_h = '';
}
if($ano > 0){ 
	$ano_s = "year(fecha)=" . $ano;
	$fecha_d = '';
	$fecha_h = '';
	if($mes > 0) $mes_s = $mes_s . " && ";
}
if($fecha_d != "")	$fecha = "fecha >= '$fecha_d' && fecha <= '$fecha_h'";


//			SELECT v.id_venta, v.fecha, remito, ve.sigla, c.nombre, operacion, dto_porc, dto_fijo, v.observaciones, p.monto AS monto_p FROM ventas v 
//			INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
//			INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
//			LEFT JOIN pagos p ON p.id_venta = v.id_venta
//			WHERE v.fecha >= '$fecha_d' && v.fecha <= '$fecha_h' $vend $f_op $f_id_v $f_id_categoria $ord

// TODO
$sql1 = "
		SELECT v.id_venta, v.fecha, 'v' AS categoria, remito, sigla, c.nombre, c.apellido, 1 AS operacion, dto_porc, dto_fijo, v.observaciones, '' AS cant, '' AS monto_p 
		FROM ventas v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_op $f_id_v $f_id_categoria $f_id_grupo
		UNION 
		SELECT v.id_visita, v.fecha, 'vi' AS categoria, '' AS remito, sigla, c.nombre, c.apellido, 2 AS operacion, '' AS dto_porc, '' AS dto_fijo, v.observaciones, '' AS cant, '' AS monto_p 
		FROM visitas v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_op $f_id_v $f_id_categoria $f_id_grupo
		UNION 
		SELECT v.id_llamado, v.fecha, 'll' AS categoria, '' AS remito, sigla, c.nombre, c.apellido, 3 AS operacion, '' AS dto_porc, '' AS dto_fijo, v.observaciones, '' AS cant, '' AS monto_p 
		FROM llamados v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_op $f_id_v $f_id_categoria $f_id_grupo
		UNION 
		SELECT p.id_venta, p.fecha, 'p' As categoria, '' As remito, sigla, c.nombre, c.apellido, 4 AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, '' AS cant, p.monto AS monto_p FROM pagos p 
		LEFT JOIN vendedores ve ON ve.id_vendedor = p.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend2 $f_op $f_id_v2 $f_id_categoria $f_id_grupo
		UNION
		SELECT pr.id_produccion AS id_venta, pr.fecha, 'pr' AS categoria, '' AS remito, 'AD' AS sigla, '' AS nombre, 'ACORDES SA' AS apellido, '5' AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, pr.cantidad AS cant, pr.costo AS monto_p FROM produccion pr
		WHERE $fecha $mes_s $ano_s $vend3
		UNION
		SELECT t.id_transferencia AS id_venta, t.fecha, 't' AS categoria, '' AS remito, 'AD' AS sigla, '' AS nombre, 'ACORDES SA' AS apellido, '6' AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, t.cantidad AS cant, t.costo AS monto_p FROM transferencia t
		WHERE $fecha $mes_s $ano_s $vend4 $ord";
$sql2 = "SELECT v.id_venta, v.fecha, 'v' AS categoria, remito, sigla, c.nombre, operacion, dto_porc, dto_fijo, v.observaciones, '' AS monto_p  FROM ventas v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_op $f_id_v $f_id_categoria $f_id_grupo $ord";
// COBRANZAS
$sql3 = "SELECT p.id_venta, p.fecha, 'p' As categoria, '' As remito, sigla, c.apellido, c.nombre, 4 AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, p.monto AS monto_p FROM pagos p
		LEFT JOIN vendedores ve ON ve.id_vendedor = p.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend2 $f_id_v $f_id_categoria $f_id_grupo $ord";
// PRODUCCION
$sql5 = "SELECT pr.id_produccion AS id_venta, pr.fecha, 'pr' AS categoria, '' AS remito, 'AD' AS sigla, 'ACORDES SA' AS apellido, '5' AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, pr.cantidad AS cant, pr.costo AS monto_p FROM produccion pr
		WHERE $fecha $mes_s $ano_s $ord";
// TRANSFERENCIAS
$sql6 = "SELECT t.id_transferencia AS id_venta, t.fecha, 't' AS categoria, '' AS remito, 'AD' AS sigla, 'ACORDES SA' AS apellido, '6' AS operacion, '' AS dto_porc, '' AS dto_fijo, '' AS observaciones, t.cantidad AS cant, t.costo AS monto_p FROM transferencia t
		WHERE $fecha $mes_s $ano_s $ord";
// VENTAS
$sql_ve = "SELECT v.id_venta, v.fecha, 'v' AS categoria, remito, sigla, 1 AS operacion, c.apellido, c.nombre, dto_porc, dto_fijo, v.observaciones, '' AS monto_p  FROM ventas v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_id_v $f_id_categoria $f_id_grupo $ord";
// VISITAS
$sql_vi = "SELECT v.id_visita AS id_venta, v.fecha, 'v' AS categoria, 0 AS remito, sigla, 2 AS operacion, c.apellido, c.nombre, 0 AS dto_porc, 0 AS dto_fijo, v.observaciones, '' AS monto_p  FROM visitas v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_id_v $f_id_categoria $f_id_grupo $ord";
// LLAMADOS
$sql_ll = "SELECT v.id_llamado AS id_venta, v.fecha, 'v' AS categoria, 0 AS remito, sigla, 2 AS operacion, c.apellido, c.nombre, 0 AS dto_porc, 0 AS dto_fijo, v.observaciones, '' AS monto_p  FROM llamados v 
		INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor 
		INNER JOIN clientes c ON c.id_cliente = v.id_cliente 
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		WHERE $fecha $mes_s $ano_s $vend1 $f_id_v $f_id_categoria $f_id_grupo $ord";

if($op == 1) $sql = $sql_ve;
if($op == 2) $sql = $sql_vi;
if($op == 3) $sql = $sql_ll;
if($op == "") $sql = $sql1;
if($op == 4) $sql = $sql3;
if($op == 5) $sql = $sql5;
if($op == 6) $sql = $sql6;

//echo($sql."<br><br>"); // IMPRIMIR LA CONSULTA

$q = query($sql);
$count = mysql_num_rows($q);
if($count > 0){
?>
  <tr><td colspan="9">&nbsp;</td></tr>
	<tr height="30">
		<td class="t" width="10%" align="center"><a href="ver_resumen_ventas.php?lado=<?= $lado?>&buscar=<?= $buscar?>&op=<?= $op?>&id_v=<?= $id_v?>&id_categoria=<?= $id_categoria?>&fecha_hasta=<?= $fecha_hasta?>&fecha_desde=<?= $fecha_desde?>&orden=sigla" title="Ordenar por Vendedor" class="link_t">V</a></td>
		<td class="t" width="10%" align="center"><a href="ver_resumen_ventas.php?lado=<?= $lado?>&buscar=<?= $buscar?>&op=<?= $op?>&id_v=<?= $id_v?>&id_categoria=<?= $id_categoria?>&fecha_hasta=<?= $fecha_hasta?>&fecha_desde=<?= $fecha_desde?>&orden=fecha" title="Ordenar por Fecha" class="link_t">Fecha</a></td>
		<td class="t" width="10%" align="center"><a href="ver_resumen_ventas.php?lado=<?= $lado?>&buscar=<?= $buscar?>&op=<?= $op?>&id_v=<?= $id_v?>&id_categoria=<?= $id_categoria?>&fecha_hasta=<?= $fecha_hasta?>&fecha_desde=<?= $fecha_desde?>&orden=remito" title="Ordenar por Remitos" class="link_t">Remito</a></td>
		<td class="t" width="35%"><a href="ver_resumen_ventas.php?lado=<?= $lado?>&buscar=<?= $buscar?>&op=<?= $op?>&id_v=<?= $id_v?>&id_categoria=<?= $id_categoria?>&fecha_hasta=<?= $fecha_hasta?>&fecha_desde=<?= $fecha_desde?>&orden=nombre" title="Ordenar por Clientes" class="link_t">Cliente</a></td>
		<td class="t" width="10%" align="center"><a href="ver_resumen_ventas.php?lado=<?= $lado?>&buscar=<?= $buscar?>&op=<?= $op?>&id_v=<?= $id_v?>&id_categoria=<?= $id_categoria?>&fecha_hasta=<?= $fecha_hasta?>&fecha_desde=<?= $fecha_desde?>&orden=operacion" title="Ordenar por Operacion" class="link_t">Op.</a></td>
		<td class="t" width="5%" align="center">C</td>
		<td class="t" width="5%" align="center">B</td>
		<td class="t" width="5%" align="center">P</td>
		<td class="t" width="20%" align="center">Monto</td>
	</tr>
<?
$reg_v = 0;
$reg_p = 0;
$reg_pr = 0;
$reg_t = 0;
$c_c_pr_T = '-';
$c_b_pr_T = '-';
$c_p_pr_T = '-';
$c_c_t_T = '-';
$c_b_t_T = '-';
$c_p_t_T = '-';

$c = 0;
	while($rs = mysql_fetch_array($q)){
	
		$id_venta = $rs['id_venta'];
		$fecha = $rs['fecha'];
		$categoria = $rs['categoria'];
		$remito = $rs['remito'];
		$vendedor = $rs['sigla'];
		$cliente = $rs['apellido'];
		$n = $rs['nombre'];
		if($n != "") $cliente = $cliente.", ".$n;
		$obsaervaciones = $rs['observaciones'];
		if($categoria == 'p') $monto_p = $rs['monto_p'];
		if($categoria == 'pr') $monto_pr = $rs['monto_p'] * $rs['cant'];
		if($categoria == 't') $monto_t = $rs['monto_p'] * $rs['cant'];


		$operacion = $rs['operacion'];
			if($operacion == 1) $visita = "VEN";
			if($operacion == 2) $visita = "VIS";
			if($operacion == 3) $visita = "LLA";
			if($operacion == 4) $visita = "COB";
			if($operacion == 5) $visita = "PRO";
			if($operacion == 6) $visita = "TRA";
		$dto_porc = $rs['dto_porc'];
		$dto_fijo = $rs['dto_fijo'];

		$cant = 0;
		$m_p = 0;
		$c_c = 0;
		$c_b = 0;
		$c_p = 0;
		$c_e = 0;

		$q_ved = query("SELECT * FROM ventas_detalle vd 
					INNER JOIN productos p ON p.id_producto = vd.id_producto 
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
					WHERE id_venta = $id_venta");
		$q_vid = query("SELECT * FROM visitas_detalle vd 
					INNER JOIN productos p ON p.id_producto = vd.id_producto 
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
					WHERE id_visita = $id_venta");
					
		if($operacion != 2) $q2 = $q_ved;
		if($operacion == 2) $q2 = $q_vid;

		if($operacion != 3){
			while($rs2 = mysql_fetch_array($q2)){
				$regalo = $rs2['regalo'];
				if($regalo != 1){
					$cant += $rs2['cant'];			
					$precio = $rs2['precio_final'];
					if($precio == "") $precio = $rs2['precio'];
					$m_p += $rs2['cant'] * $precio;
					$unidades = $rs2['unidades'];
					if($unidades > 1)	$c_c += $rs2['cant'];
					if($unidades == 1) $c_b += $rs2['cant'];
					$ue = $rs2['ue'];
					$m_p_eq += $rs2['cant'] * $precio * $ue;
				}else{
					$c_p += $rs2['cant'];
				}
			}
		}
		$cant = $c_c + $c_b / 6;
		if($categoria == "v"){
			if($operacion == 1) $monto_v = $m_p;
			if($operacion != 1) $monto_o = $m_p;
		}
		else{
			$monto_vo = 0;
		}
		//SUMO LAS CANTIDADES

			$cant_T += $cant;
			$c_c_T += $c_c;
			$c_b_T += $c_b;
			$c_p_T += $c_p;
			
			if($categoria == "p"){
				$c_c_p_T += $c_c;
				$c_b_p_T += $c_b;
				$c_p_p_T += $c_p;
				$reg_p += 1; 
			}
			if($categoria == "v"){
				if($operacion == 1){
					$c_c_v_T += $c_c;
					$c_b_v_T += $c_b;
					$c_p_v_T += $c_p;
					$reg_v += 1;
				}
				if($operacion != 1){
					$c_c_o_T += $c_c;
					$c_b_o_T += $c_b;
					$c_p_o_T += $c_p;
					$reg_o += 1;
				}
				$c_c_vo_T += $c_c;
				$c_b_vo_T += $c_b;
				$c_p_vo_T += $c_p;
				$reg_vo_T += 1;
			}
			if($categoria == "vi" || $categoria == "ll"){
				$c_c_o_T += $c_c;
				$c_b_o_T += $c_b;
				$c_p_o_T += $c_p;
				$reg_o += 1;
				$reg_vo_T += 1;
			}
			if($categoria == "pr"){
				$c_c = '-';
				$c_b = '-';
				$c_p = '-';
				$c_c_pr_T = '-';
				$c_b_pr_T = '-';
				$c_p_pr_T = '-';
				$reg_pr += 1;
			}
			if($categoria == "t"){
				$c_c = '-';
				$c_b = '-';
				$c_p = '-';
				$c_c_t_T = '-';
				$c_b_t_T = '-';
				$c_p_t_T = '-';
				$reg_t = 1;
			}
		// --------
			$monto_v_T += $monto_v;
			$monto_o_T += $monto_o;
			$monto_p_T += $monto_p;
			$monto_pr_T += $monto_pr;
			$monto_t_T += $monto_t;

			$monto_vo_T += $monto_vo;

			if($monto_o_T == "") $monto_o_T = 0;

			if($categoria == 'v') $m = $monto_v;
			if($categoria == 'p'){
				if($op == "") $m = - $monto_p;
				if($op == 4) $m = $monto_p;
			}
			if($categoria == 'pr') $m = $monto_pr;
			if($categoria == 't') $m = $monto_t;
			//echo($monto_v_T." - ".$monto_p_T);
			$monto_T += $m;

			if($monto_v != 0.00){
				 $monto_v = "$&nbsp;" . number_format($monto_v,2,'.',',')."&nbsp;";
			}
			else{
				$monto_v = '';			
			}
			if($monto_p != 0.00){
				if($op == ""){
					$monto_p = "($&nbsp;" . number_format($monto_p,2,'.',',').")";
				}else{
					$monto_p = "$&nbsp;" . number_format($monto_p,2,'.',',');				
				}
			}
			else{
				$monto_p = '';
			}
			if($monto_pr != 0.00){
				$monto_pr = "$&nbsp;" . number_format($monto_pr,2,'.',',');				
			}
			else{
				$monto_pr = '';
			}
		//}

		$reg += 1;
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>  
		<tr height="30">
			<td class="<?= $c?>" align="center"><?=$vendedor?></td>
			<td class="<?= $c?>" align="center"><? formatoFecha2($fecha)?></td>
			<td class="<?= $c?>" align="center"><?= $remito?>&nbsp;</td>
			<td class="<?= $c?>"><?= substr($cliente,0,25)?></td>
			<td class="<?= $c?>" align="center"><?=$visita?></td>
			<td class="<?= $c?>" align="center"><?=$c_c?></td>
			<td class="<?= $c?>" align="center"><?=$c_b?></td>
			<td class="<?= $c?>" align="center"><?=$c_p?></td>
			<td class="<?= $c?>" align="right">
			<?
			if($categoria == 'v') echo("$monto_v");
			if($categoria == 'p') echo("$monto_p");
			if($categoria == 'pr') echo("$monto_pr");
			if($categoria == 't') echo("$monto_t");
			?>
			</td>
		</tr>
	<? if($operacion != 1 && $operacion != 4 && $operacion != 5 && $operacion != 6){?>

		<tr height="30">
			<td class="<?= $c?>" colspan="1">&nbsp;</td>
			<td class="<?= $c?>" colspan="8" align="center">
				<table width="97%" cellpadding="0" cellpadding="0" border="0">
					<tr height="5"><td></td></tr>
					<tr><td class="<?= $c?>"><?= $obsaervaciones?></td></tr>
					<tr height="5"><td></td></tr>
				</table>
			</td>
		</tr>
		<tr height="2"><td class="<?= $c?>" colspan="9"></td></tr>
	<?
		}
		$c ++;
	}
	if($op == ""){
	?>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Subotal ventas</td>
			<td class="t" align="center"><?= $reg_v?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_v_T?></td>
			<td class="t" align="center"><?=$c_b_v_T?></td>
			<td class="t" align="center"><?=$c_p_v_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_v_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Visitas y LLamados</td>
			<td class="t" align="center"><?= $reg_o?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center">-</td>
			<td class="t" align="center">-</td>
			<td class="t" align="center">-</td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_o_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		  <tr><td colspan="9"></td></tr>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Total ventas y otros</td>
			<td class="t" align="center"><?= $reg_vo_T?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_vo_T?></td>
			<td class="t" align="center"><?=$c_b_vo_T?></td>
			<td class="t" align="center"><?=$c_p_vo_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_vo_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Subotal Cobrados</td>
			<td class="t" align="center"><?= $reg_p?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_p_T?></td>
			<td class="t" align="center"><?=$c_b_p_T?></td>
			<td class="t" align="center"><?=$c_p_p_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_p_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		<? if($_SESSION['admin']=="ok"){?>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Subotal Produccion</td>
			<td class="t" align="center"><?= $reg_pr?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_pr_T?></td>
			<td class="t" align="center"><?=$c_b_pr_T?></td>
			<td class="t" align="center"><?=$c_p_pr_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_pr_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		  <tr height="20">
			<td class="t" colspan="3">&nbsp;&nbsp;Subotal Transferencias</td>
			<td class="t" align="center"><?= $reg_t?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_t_T?></td>
			<td class="t" align="center"><?=$c_b_t_T?></td>
			<td class="t" align="center"><?=$c_p_t_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_t_T,2,'.',',')?>&nbsp;</td>
		  </tr>
		<? }?>
		  <tr><td colspan="9"></td></tr>
	<? }?>
		  <tr height="30">
			<td class="t">&nbsp;</td>
			<td class="t">&nbsp;</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?= $reg?>&nbsp;Registros</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><?=$c_c_T?></td>
			<td class="t" align="center"><?=$c_b_T?></td>
			<td class="t" align="center"><?=$c_p_T?></td>
			<td class="t" align='right'>$&nbsp;<?= number_format($monto_T,2,'.',',')?>&nbsp;</td>
		  </tr>

<? 
}
else{
	if($fecha_desde != "--" && $fecha_hasta != "--"){
?>
	  <tr><td colspan="9">&nbsp;</td></tr>
	  <tr class="error"><td colspan="9" align="center">No se ha encontrado ninguna dato.</td></tr>
<?
	}
}
?>
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
