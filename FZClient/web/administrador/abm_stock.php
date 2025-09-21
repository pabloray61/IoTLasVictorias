<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");


// ------- IMPRIMIR O INSERTAR ----------------
	$insertar = "ok";
	//$imprimir = "ok";
// -------------------------------------------

if($_REQUEST['aplicar'] == "ok"){
	$q = query("SELECT * FROM stock s INNER JOIN productos p ON p.id_producto = s.id_producto");
	while($rs = mysql_fetch_array($q)){
		$id_stock = $rs['id_stock'];
		$cantidad = $rs['cantidad'];
		$merma = $_REQUEST['merma'.$id_stock];
		if($merma != ""){
			//echo("id stock: ".$rs['producto']." -- Merma: ".$merma."<br>");
			$cant = $cantidad + $merma;
			if($cant > 0) $sql = "UPDATE stock SET cantidad = $cant WHERE id_stock = $id_stock";
			if($cant <= 0) $sql = "DELETE FROM stock WHERE id_stock = $id_stock";
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo($sql."<br>");
			
			$id_producto = $rs['id_producto'];
			$id_deposito = $rs['id_deposito'];
			$fecha = $_REQUEST['fecha'];
				list($dia, $mes, $ano) = split( '[/.-]', $fecha);
				$fecha = $ano."-".$mes."-".$dia;
			$detalle = $_REQUEST['detalle'];

			$sql2 =  "INSERT INTO mermas (id_merma, id_producto, id_deposito, fecha, cantidad, detalle) VALUES (NULL, $id_producto, $id_deposito, '$fecha', $merma, '$detalle')";
			if($insertar == "ok") mysql_query($sql2, $conn_id);
			if($imprimir == "ok") echo($sql2."<br>");
		}
	}
}

if ($_REQUEST["borrar"] == 'ok'){
	$id_merma = $_REQUEST['id_merma'];
	$id_p = $_REQUEST['id_producto'];
	$id_d = $_REQUEST['id_deposito'];
	$cant = $_REQUEST['cantidad'];

	$qi = query("SELECT * FROM stock WHERE id_producto = $id_p && id_deposito = $id_d");
	$ri = mysql_fetch_array($qi);
	$c = $ri['cantidad'];
	if($c == "") $c = 0;
	$cantidad = $c - $cant;

	if($cantidad > 0){
		$sql = "DELETE FROM mermas where id_merma = $id_merma";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");
		if($c != 0)	$sql2 = "UPDATE stock SET cantidad = $cantidad where id_producto = $id_p && id_deposito = $id_d";
		if($c == 0)	$sql2 = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p, $id_d, $cantidad)";

		if($insertar == "ok") mysql_query($sql2, $conn_id);
		if($imprimir == "ok") echo($sql2."<br>");			
	}
	else{
		$msg = "No es posible borrar esta merma.<br>En dicho deposito hay un stock menor al que desea borrar.";
	}
}
?>		
<script language="javascript">
function confirmar(){
	return confirm("Estas seguro que queres aplicar los cambios de stock?");
}
function showHide (obj) { 
	if (obj.style.visibility == "hidden") { 
		obj.style.visibility = "visible"; 
	} else { 
		obj.style.visibility = "hidden"; 
	} 
}
</script>
<script language="javascript" src="calendar1.js"></script>

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

	
<p align="center" class="titulo">Control de Stocks</p>

<table width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center" width="50%"><a href="imp_stock.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir la lista de Stock</a></td>
		<td align="center" width="50%"><a href="imp_productos.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir la lista de Productos</a></td>
	</tr>
</table>
<form name="formul" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<?
$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
while($rs_q = mysql_fetch_array($q_deposito)){
	$q = query("SELECT * FROM stock WHERE id_deposito = " . $rs_q['id_deposito']." GROUP BY id_producto");
	if(mysql_num_rows($q)>0){
?>
	  <p align="center" class="titulo"><strong><?=$rs_q['deposito']?></strong></p>
	<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	  <tr height="30">
		<td width="5%" class="t">&nbsp;</td>
		<td width="20%" class="t" align="center">Linea</td>
		<td width="50%" class="t" align="center">Producto</td>
		<td width="10%" class="t" align="center">Cant</td>
		<td width="10%" class="t" align="center">Ajuste</td>
		<td width="5%" class="t">&nbsp;</td>
	  </tr>
	  <?
		$q_tipo = query("SELECT * FROM p_categorias ORDER BY orden");
		$cantidad_T = 0;
		$costo_T = 0; 	
		while($rs_t = mysql_fetch_array($q_tipo)){
			$id_categoria = $rs_t['id_categoria'];
			$categoria = $rs_t['categoria'];
			$cantidad_p_T = 0;
			$q = query("SELECT p.id_producto, s.id_stock, s.cantidad, l.linea, v.variedad, v.sigla, pp.presentacion, pp.unidades, pp.volumen FROM stock s
						INNER JOIN productos p ON p.id_producto = s.id_producto 
						INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
						INNER JOIN p_lineas l ON l.id_linea = p.id_linea 
						INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE id_deposito = " . $rs_q['id_deposito']." && p.id_categoria = $id_categoria
						GROUP BY s.id_producto");
			if(mysql_num_rows($q) > 0){
				while($rs=mysql_fetch_array($q)){
					$id_producto = $rs['id_producto'];
					$id_stock = $rs['id_stock'];
					$linea = $rs['linea'];
					$variedad = " - ".$rs['variedad'];
					$sigla = $rs['sigla'];
					$presentacion = $rs['presentacion']." (".$rs['unidades']." x ". $rs['volumen']." ml.)";
					
					if($variedad == " - Todas") $variedad = "";
					
					$producto = $linea."".$variedad." - ". $presentacion;
					
					$cantidad = $rs['cantidad'];
					$costo = $rs['costo'];
	
					$cantidad_p_T += $cantidad;
					$cantidad_T += $cantidad;
					$costo_T += $costo * $cantidad; 
		
					$reg += 1;
					$c = $flag ? "c1":"c2";
					$flag = !$flag;
					?>
					<tr height="30">
						<td class="<?= $c?>" align="center">&nbsp;</td>
						<td class="<?= $c?>">&nbsp;<?= $categoria?></td>
						<td class="<?= $c?>">&nbsp;<?= $producto?></td>
						<td class="<?= $c?>" align="center"><?= number_format($cantidad, 0, ',', '.')?></td>
						<td class="<?= $c?>" align="center"><input type="text" size="3" name="merma<?= $id_stock?>" value=""></td>
						<td class="<?= $c?>" align="center">&nbsp;</td>
					</tr>
				<? 	
					$tp = $rs['tipo_producto'];
				} // cierro el while de la consulta de stock
			?>
			<tr height="25">
				<td class="t2" align="center">&nbsp;</td>
				<td class="t2" align="center"><b><?= $tipo_producto?></b></td>
				<td class="t2">&nbsp;</td>
				<td class="t2" align="center"><b><?= number_format($cantidad_p_T, 0, ',', '.')?></b></td>
				<td class="t2" align="center">&nbsp;</td>
				<td class="t2" align="center">&nbsp;</td>
			</tr>	
		<? 
			} // cierro el if
		}
		?>
		<tr height="30">
			<td class="t">&nbsp;</td>
			<td class="t">&nbsp;</td>
			<td class="t"><?= $x?></td>
			<td class="t" align="center"><b><?= number_format($cantidad_T, 0, ',', '.')?></b></td>
			<td class="t" align="center"><b><?= $cantidad_M_T?></b></td>
			<td class="t" align="center">&nbsp;</td>
		</tr>
	</table>
	<br>
  <? 
	}
	else{
		//echo("<p class='error' align='center'>No hay Stock cargado.</p>");
	}
}
// --------------------------------------------------------------------------------------------------------------------------
if($v == "") $v = 1;
if($visibility == "") $visibility = "hidden";
if($fecha == "00-00-0000") $fecha = "";
if($fecha == "--") $fecha = "";
//if($fecha == "") 
$fecha = date(d."-".m."-".Y);
?>
<table align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="data" colspan="2" align="center">
			Aplicar los ajustes&nbsp;<input type="checkbox" value="<?= $v?>" name="guardar" onclick="showHide(td);"<?= $s?>>&nbsp;
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td style="visibility: <?= $visibility?>;" id="td" colspan="2" class="data" align="center">
			<input name="fecha" type="text" size="10" value="<?= $fecha?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"><br>
			<textarea name="detalle" rows="3" cols="50"></textarea><br><br>
			<input type="submit" name="aplicar" value="ok" onClick="return confirmar();"><br>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
			<script language="javascript">
			var cal1 = new calendar1(document.forms['formul'].elements['fecha']);
							cal1.year_scroll = true;
							cal1.time_comp = false;
			</script>
</form>



<p class="error" align="center"><?=$msg?></p>


<?
$q = query("SELECT * FROM mermas");
if(mysql_num_rows($q)>0){

	$buscar = $_REQUEST['buscar'];
	$fecha_desde = $_REQUEST['fecha_desde'];
	$fecha_hasta = $_REQUEST['fecha_hasta'];
	if($fecha_desde == ''){
		$mes = $_REQUEST['mes'];
		$ano = $_REQUEST['ano'];
	}
	
	if($buscar == "") $buscar = 1;
	?>
	<table width="500" cellpadding="0" cellspacing="0" align="center">
		<form name="formu" action="<?= $_SERVER['PHP_SELF']."?".ahora()?>" method="post">
			<tr height="40"><td colspan="3" align="center" class="t">Ver lotes de produccion</td></tr>
			<tr height="50">
				<td class="c1">&nbsp;</td>
				<td class="c1"align="center" >Fecha&nbsp;&nbsp;
					<select name="buscar" onChange="formu.submit();">
						<option value="1" <? if($buscar == 1){echo " SELECTED ";}?>>Mes en Curso</option>
						<option value="3" <? if($buscar == 3){echo " SELECTED ";}?>>Años / Meses</option>
						<option value="4" <? if($buscar == 4){echo " SELECTED ";}?>>Determinar Fecha</option>
					</select>&nbsp;&nbsp;
				</td>
				<td class="c1">&nbsp;</td>
			</tr>
			<?
			if($buscar == 1){
				$dias = date(d);
				$resta = -($dias-1);
			}
			//if($buscar == 2)
			if($buscar == 3){
				if($_REQUEST['ano'] == "") $ano = date(Y);
				if($_REQUEST['mes'] == "") $mes = date(m);
			?>
				<tr height="50">
					<td class="c2">&nbsp;</td>
					<td class="c2" align="center">
						<table width="70%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="c2" width="10%">A&ntilde;o</td>
								<td class="c2" width="40%">
									<select name="ano" onChange="javascript:formu.submit();">
										<option value="0">Todos</option>
										<?
										$hoy = getdate();
										for($a = 2000; $a <= $hoy['year']+1; $a++){
										?>
											<option <? if($ano == $a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
										<? }?>
									</select>								
								</td>
								<td class="c2" width="10%">Mes</td>
								<td class="c2" width="40%">
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
					</td>
					<td class="c2">&nbsp;</td>
				</tr>
			<?
			}
			if($buscar == 4){
			?>
				<tr height="50">
					<td class="c2">&nbsp;</td>
					<td class="c2" align="center">
						<table width="98%" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="9" align="center">Desde&nbsp;&nbsp;
									<input name="fecha_desde" type="text" size="10" value="<?= $fecha_desde?>">&nbsp;
									<img src="images/cal.gif" onClick="javascript:cal1.popup();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Hasta&nbsp;&nbsp;
									<input name="fecha_hasta" type="text" size="10" value="<?= $fecha_hasta?>">&nbsp;
									<img src="images/cal.gif" onClick="javascript:cal12.popup();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="images/b_search.png" onClick="formu.submit();">
								</td>
							</tr>
							</tr>
						</table>
					</td>
					<td class="c2">&nbsp;</td>
				</tr>
				<?
				list($dia_h, $mes_h, $ano_h) = split( '[/.-]', $fecha_hasta);
				$fecha_h = $ano_h."-".$mes_h."-".$dia_h;
				list($dia_d, $mes_d, $ano_d) = split( '[/.-]', $fecha_desde);
				$fecha_d = $ano_d."-".$mes_d."-".$dia_d;
			}
			?>
			<tr height="15"><td colspan="3" class="t">&nbsp;</td></tr>
		</form>
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
		$mes_s = "WHERE month(fecha)=" . $mes;
		$fecha_d = '';
		$fecha_h = '';
	}
	if($ano > 0){ 
		$ano_s = "year(fecha)=" . $ano;
		$fecha_d = '';
		$fecha_h = '';
		if($mes > 0) $mes_s = $mes_s . " && ";
		if($mes == 0) $ano_s = "WHERE ".$ano_s;
	}
	if($fecha_d != "")	$f = "WHERE fecha >= '$fecha_d' && fecha <= '$fecha_h'";
	if($f == "--") $f = "";
	$q = query("SELECT * FROM mermas $f $mes_s $ano_s");
	
	if(mysql_num_rows($q)>0){
	?>
		<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr><td colspan="5" align="center" class="titulo"><b><?=$rs_q['deposito']?></b></td></tr>
			<tr><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
			<tr><td colspan="5" align="center"><a href="imp_ajustes.php?buscar=<?= $buscar?>&mes=<?= $mes?>&ano=<?= $ano?>&fecha_d=<?= $fecha_d?>&fecha_h=<?= $fecha_h?>" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir Ajustes</a></td></tr>
			<tr><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
			<tr height="30">
				<td width="10%" class="t" align="center">Fecha</td>
				<td width="50%" class="t" align="center">Producto</td>
				<td width="30%" class="t" align="center">Deposito</td>
				<td width="5%" class="t" align="center">Ajuste</td>
				<td width="5%" class="t">&nbsp;</td>
			</tr>
	  <?
		$cantidad_T = 0;
		$costo_T = 0; 		
		while($rs = mysql_fetch_array($q)){
			$id_producto = $rs['id_producto'];		
			$qp = query("SELECT p.id_producto, c.categoria, l.linea, v.variedad, v.sigla, pp.presentacion, pp.unidades, pp.volumen FROM productos p
						INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
						INNER JOIN p_lineas l ON l.id_linea = p.id_linea 
						INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE id_producto = $id_producto");
			$rp = mysql_fetch_array($qp);
			
				$id_producto = $rp['id_producto'];
				$id_stock = $rp['id_stock'];
				$categoria = $rp['categoria'];
				$linea = $rp['linea'];
				$variedad = " - ".$rp['variedad'];
				$sigla = $rp['sigla'];
				$presentacion = $rp['presentacion']." (".$rp['unidades']." x ". $rp['volumen']." ml.)";
				
				if($variedad == " - Todas") $variedad = "";
				
				$producto = $categoria." ".$linea."".$variedad." - ". $presentacion;

			$id_deposito = $rs['id_deposito'];		
			$qd = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
			$rd = mysql_fetch_array($qd);
			
			$deposito = $rd['deposito'];
			
			$fecha = $rs['fecha'];
			list($ano, $mes, $dia) = split( '[/.-]', $fecha);
			$ano = substr($ano, 2,2);
			$fecha = $dia."/".$mes."/".$ano;
			$cantidad = $rs['cantidad'];

			$cantidad_T += $cantidad;

			$reg += 1;
			$c = $flag ? "c1":"c2";
			$flag = !$flag;
			?>
			<tr height="30">
			  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<td class="<?= $c?>" align="center"><?= $fecha?></td>
				<td class="<?= $c?>">&nbsp;<?= $producto?></td>
				<td class="<?= $c?>" align="center"><?= $deposito?></td>
				<td class="<?= $c?>" align="center"><?= number_format($cantidad, 0, ',', '.')?></td>
				<td class="<?= $c?>" align="center"><input type="image" name="img" src="images/b_no.png" onClick="return confirmar();"></td>
				<input type="hidden" name="borrar" value="ok">
				<input type="hidden" name="id_merma" value="<?= $rs['id_merma']?>">
				<input type="hidden" name="id_producto" value="<?= $id_producto?>">
				<input type="hidden" name="id_deposito" value="<?=$rs['id_deposito']?>">
				<input type="hidden" name="cantidad" value="<?=$cantidad?>">
			  </form>
			</tr>
		<? }?>
			<tr height="25">
				<td class="t">&nbsp;</td>
				<td class="t"><?= $x?></td>
				<td class="t" align="center">&nbsp;</td>
				<td class="t" align="center"><?= $cantidad_T?></td>
				<td class="t">&nbsp;</td>
			</tr>
	  </table>
	<br>
  <? }?>


	<? if($buscar == 4){?>
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
<? }?>

<br><hr><br>

	<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	  <tr><td colspan="5" align="center" class="encabezado">Consolidado total de Productos</td></tr>
	  <tr><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>
	  <tr><td colspan="5" align="center"><a href="imp_consolidado.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir el Consolidado</a></td></tr>
	  <tr><td colspan="5" align="center" class="encabezado">&nbsp;</td></tr>


<?

	$cantidad_T = 0;
	$l_c = query("SELECT * FROM p_presentacion GROUP BY presentacion");
	while($rsl_c = mysql_fetch_array($l_c)){
		$id_presentacion = $rsl_c['id_presentacion'];
		$presentacion = $rsl_c['presentacion'];
		$cant_c_T = 0;
		$reg = 0;
		$qt_c = query("SELECT p.id_categoria, c.categoria, s.id_producto, l.linea, v.variedad, pp.presentacion, pp.unidades, pp.volumen, SUM(s.cantidad) AS cantidad FROM stock s
					INNER JOIN productos p ON p.id_producto = s.id_producto
					INNER JOIN p_categorias c ON c.id_categoria = p.id_categoria
					INNER JOIN p_lineas l ON l.id_linea = p.id_linea 
					INNER JOIN p_variedades v ON v.id_variedad = p.id_variedad
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
					WHERE pp.presentacion = '$presentacion'
					GROUP BY s.id_producto");
		?>
		<tr height="30"><td colspan="5" align="center" class="t">Presentacion en <?= $presentacion?></td></tr>
		<tr height="20">
			<td width="5%" class="t2">&nbsp;</td>
			<td width="30%" class="t2" align="center">Categoria</td>
			<td width="50%" class="t2" align="center">Producto</td>
			<td width="10%" class="t2" align="center">Cant</td>
			<td width="5%" class="t2">&nbsp;</td>
		</tr>
		<?			
		if(mysql_num_rows($qt_c) > 0){
			while($rp = mysql_fetch_array($qt_c)){
							
				$categoria = $rp['categoria'];
				$linea = $rp['linea'];
				$variedad = " - ".$rp['variedad'];
				$sigla = $rp['sigla'];
				$presentacion = " (".$rp['unidades']." x ". $rp['volumen']." ml.)";
				
				if($variedad == " - Todas") $variedad = "";
				$producto = $linea."".$variedad." - ". $presentacion;
				
				$cantidad_c = $rp['cantidad'];
				$cant_c_T += $cantidad_c;
				$cantidad_T += $cantidad_c;
				$reg += 1;
				$x_T += 1;
				
				$bg = $flag ? "c1":"c2";
				$flag = !$flag;
				?>
				<tr height="30">
					<td class="<?= $c?>" align="center">&nbsp;</td>
					<td class="<?= $c?>">&nbsp;<?= $categoria?></td>
					<td class="<?= $c?>">&nbsp;<?= $producto?></td>
					<td class="<?= $c?>" align="center"><?= number_format($cantidad_c, 0, ',', '.')?></td>
					<td class="<?= $c?>">&nbsp;</td>
				</tr>
				<? 
			}
		}
		else{
			$bg = $flag ? "c1":"c2";
			$flag = !$flag;
			?>
			<tr height="40">
				<td class="<?= $c?>" align="center">&nbsp;</td>
				<td class="<?= $c?>">&nbsp;<?= $categoria?></td>
				<td class="<?= $c?>" align="center">No hay stock cargado</td>
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>">&nbsp;</td>
			</tr>
		<? }?>
		<tr height="25">
			<td class="t">&nbsp;</td>
			<td class="t">&nbsp;</td>
			<td class="t" align="center"><b><?= $reg?> Registro<? if($reg != 1) echo("s")?></b></td>
			<td class="t" align="center"><b><?= number_format($cant_c_T, 0, ',', '.')?></b></td>
			<td class="t">&nbsp;</td>
		</tr>
		<tr height="20"><td colspan="5"></td></tr>
	<? }?>
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
