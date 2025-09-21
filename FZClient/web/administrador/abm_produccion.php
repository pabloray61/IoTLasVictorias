<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";

// ------- IMPRIMIR O INSERTAR ----------------
	$insertar = "ok";
	//$imprimir = "ok";
// -------------------------------------------

$fecha = $_REQUEST['fecha'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha);
	$fecha = $ano."-".$mes."-".$dia;

if ($_REQUEST["agregar"] == "ok" and $_REQUEST["cantidad"]!=""){
	$cos = ereg_replace(',', '.', $_REQUEST['costo']);
	if($cos == '') $cos = 0;

	$sql =  "INSERT INTO produccion (id_produccion, id_producto, id_deposito, fecha, cantidad, costo, numero, observaciones) VALUES (NULL, ".$_REQUEST['id_producto'].",".$_REQUEST["id_deposito"].", '$fecha', ".$_REQUEST['cantidad'].", ".$cos.", '". $_REQUEST['numero']."', '".$_REQUEST['observaciones']."')";
	if($insertar == "ok") mysql_query($sql, $conn_id);
	if($imprimir == "ok") echo($sql."<br>");

	$q = query("SELECT * FROM stock WHERE id_producto = ". $_REQUEST['id_producto'] ." && id_deposito = ".$_REQUEST['id_deposito']);
	if(mysql_num_rows($q) == 0){ // Si no esta cargado este producto en este deposito lo inserta normalmente.
		$sql2 = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, ".$_REQUEST['id_producto'].",".$_REQUEST["id_deposito"].", ".$_REQUEST['cantidad'].")";
	}
	else{ // Si ya esta cargado este producto en este deposito solo agrega lo que se carga.
		$rs = mysql_fetch_array($q);
		$id_stock = $rs['id_stock'];
		$cantidad = $rs['cantidad'] + $_REQUEST['cantidad'];
		$sql2 = "UPDATE stock SET cantidad = $cantidad WHERE id_stock = $id_stock";
	}
	if($insertar == "ok") mysql_query($sql2, $conn_id);
	if($imprimir == "ok") echo($sql2."<br>");
}
if ($_REQUEST['modificar'] == "ok"){
	$id_produccion = $_REQUEST['id_produccion'];
	$id_producto = $_REQUEST['id_producto'];
	$id_deposito = $_REQUEST['id_deposito'];
	$costo = ereg_replace(',', '.', $_REQUEST['costo']);
	$c_n = $_REQUEST['cantidad']; // cant nueva

	$q_a = query("SELECT * FROM produccion WHERE id_produccion = $id_produccion");
	$rs_a = mysql_fetch_array($q_a);
	$c_a = $rs_a['cantidad']; // cantidad q estaba cargada
	$q = query("SELECT * FROM stock WHERE id_producto = $id_producto && id_deposito = $id_deposito");
	$rs = mysql_fetch_array($q);
	$c = $rs['cantidad']; // cantidad q ya esta cargada de ese prod en ese deposito

	$cant = $c - $c_a + $c_n;
	echo("cant: ".$cant." = ".$c." - ".$c_a." + ".$c_n."<br>");

	if($cant >= 0){
		if($c_n != 0) $sql = "UPDATE produccion SET fecha= '$fecha', cantidad = $c_n, costo = $costo, numero = '".$_REQUEST['numero'] ."', observaciones = '".$_REQUEST['observaciones'] ."' WHERE id_produccion = " . $_REQUEST['id_produccion'];
		if($c_n == 0) $sql = "DELETE FROM produccion WHERE id_produccion = " . $_REQUEST['id_produccion'];
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");
		if($cant == 0){
			$sql2 = "DELETE FROM stock where id_producto = $id_producto && id_deposito = $id_deposito";
			if($insertar == "ok") mysql_query($sql2, $conn_id);
			if($imprimir == "ok") echo($sql2."<br>");			
		}
		else{
			$sql2 = "UPDATE stock SET cantidad = $cant where id_producto = $id_producto && id_deposito = $id_deposito";
			if($insertar == "ok") mysql_query($sql2, $conn_id);
			if($imprimir == "ok") echo($sql2."<br>");						
		}
	}
	//unset($id_producto, $id_deposito, $cantidad, $costo, $numero, $observaciones);
}

if ($_REQUEST["borrar"] == 'ok'){
	$id_produccion = $_REQUEST['id_produccion'];
	$id_producto = $_REQUEST['id_producto'];
	$id_deposito = $_REQUEST['id_deposito'];
	$cant = $_REQUEST['cantidad'];

	$q = query("SELECT * FROM stock WHERE id_producto = $id_producto && id_deposito = $id_deposito");
	$rs = mysql_fetch_array($q);
	$c = $rs['cantidad'];
	if($c > $cant){
		$sql = "DELETE FROM produccion where id_produccion = $id_produccion";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$cant = $c - $cant;
		$sql2 = "UPDATE stock SET cantidad = $cant where id_producto = $id_producto && id_deposito = $id_deposito";
		if($insertar == "ok") mysql_query($sql2, $conn_id);
		if($imprimir == "ok") echo($sql2."<br>");
	}
	elseif($c == $cant){
		$sql = "DELETE FROM produccion where id_produccion = $id_produccion";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$sql2 = "DELETE FROM stock where id_producto = $id_producto && id_deposito = $id_deposito";
		if($insertar == "ok") mysql_query($sql2, $conn_id);
		if($imprimir == "ok") echo($sql2."<br>");
		header("Location:abm_produccion.php?v=". date(d."-".m."-".Y.".:.".G.":".i.":".s));
	}
	else{
		$msg = "No es posible borrar este ingreso de stock.<br>En dicho deposito hay un stock menor al que desea borrar.";
	}
}


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

	
<p align="center" class="titulo">ABM Lotes de Produccion</p>

<?
if($ver == "agregar"){

	// Productos
	$q_producto = query("SELECT id_producto, categoria, linea, sigla, presentacion, unidades, volumen FROM productos p
						INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						ORDER BY p.orden");
	// Depositos
	$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");

	?>

	<table width="500" cellpadding="0" cellspacing="0" align="center">
		<tr height="30"><td colspan="4" align="center" class="t">Agregar un Lote</td></tr>
		<form name="agregar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="30">
				<td class="c1" width="5%">&nbsp;</td>
				<td class="c1" width="25%">Producto</td>
				<td class="c1" width="65%">
					<select name="id_producto">
						<option value="">--------></option>
						<? 
						while($rs_q = mysql_fetch_array($q_producto)){
							$producto = $rs_q['categoria']." ".$rs_q['linea']." - ". $rs_q['sigla']." ".$rs_q['presentacion']." (".$rs_q['unidades']."x".$rs_q['volumen'].")";
							?>
							<option value="<?=$rs_q['id_producto']?>"><?= $producto?></option>
						<? }?>
					</select>	
				</td>
				<td class="c1" width="30%">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Deposito</td>
				<td class="c2">
					<select name="id_deposito">
						<option value="">--------></option>
						<? while($rs_q = mysql_fetch_array($q_deposito)){?>
							<option value="<?=$rs_q['id_deposito']?>"><?=$rs_q['deposito']?></option>
						<? }?>
					</select>
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
			<?
			$hoy = date(d."-".m."-".Y);
			?>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">Fecha</td>
				<td class="c1"><input name="fecha" type="text" size="10" value="<?= $hoy?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Cantidad</td>
				<td class="c2"><input name="cantidad" type="text" size="5"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">Costo U</td>
				<td class="c1"><input name="costo" type="text" size="5"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">N° Prod.</td>
				<td class="c2"><input name="numero" type="text" size="15"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="60">
				<td class="c1">&nbsp;</td>
				<td class="c1">Observaciones</td>
				<td class="c1"><textarea name="observaciones" rows="3" cols="50"></textarea></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="45">
				<td class="t" colspan="4" align="center">
					<input type="image" src="images/b_insert.png" onClick="return confirm('Estás seguro que queres agregar el lote?');" title="Agregar el lote de produccion">
					<input type="hidden" name="agregar" value="ok">
				</td>
			</tr>
		</form>
	</table>
<? } // Cierro el if de si no viene un id_produccion como para modificar

// MODIFICAR ------------------------------------------------------------------------------------------

if($ver == "modificar"){
	$qp = query("SELECT * FROM produccion p 
				INNER JOIN productos pr ON p.id_producto = pr.id_producto 
				WHERE id_produccion = ".$_REQUEST['id_produccion']);
	$rsp = mysql_fetch_array($qp);
	$id_produccion = $rsp['id_produccion'];
	$id_producto = $rsp['id_producto'];
	$id_deposito = $rsp['id_deposito'];
	$fecha = $rsp['fecha'];
	$cantidad = $rsp['cantidad'];
	$costo = $rsp['costo'];
	$costo = ereg_replace('[.]', ',', $costo);
	$numero = $rsp['numero'];
	$observaciones = $rsp['observaciones'];
	
		// Productos
	$q_producto = query("SELECT id_producto, categoria, linea, sigla, presentacion, unidades, volumen FROM productos p
						INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						ORDER BY p.orden");
	// Depositos
	$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");

?>
	<table width="500" cellpadding="0" cellspacing="0" align="center">
		<tr height="30"><td colspan="4" align="center" class="t">Modificar un Lote</td></tr>
		<form name="modificar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="30">
				<td class="c1" width="5%">&nbsp;</td>
				<td class="c1" width="25%">Producto</td>
				<td class="c1" width="65%">
					<select name="id_producto" disabled>
						<option value="">--------></option>
						<? 
						while($rs_q = mysql_fetch_array($q_producto)){
							$producto = $rs_q['categoria']." ".$rs_q['linea']." - ". $rs_q['sigla']." ".$rs_q['presentacion']." (".$rs_q['unidades']."x".$rs_q['volumen'].")";
							?>
							<option value="<?=$rs_q['id_producto']?>" <? if($rs_q['id_producto'] == $id_producto) echo("SELECTED")?>><?= $producto?></option>
						<? }?>
					</select>	
				</td>
				<td class="c1" width="30%">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Deposito</td>
				<td class="c2">
					<select name="id_deposito" disabled>
						<option value="">--------></option>
						<? 
						while($rs_q = mysql_fetch_array($q_deposito)){
							?>
							<option value="<?=$rs_q['id_deposito']?>" <? if($rs_q['id_deposito'] == $id_deposito) echo("SELECTED")?>><?=$rs_q['deposito']?></option>
						<? }?>
					</select>
				</td>
				<td class="c2">&nbsp;</td>
			</tr> 
			<?
			$hoy = date(d."-".m."-".Y);
			?>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">Fecha</td>
				<td class="c1"><input name="fecha" type="text" size="10" value="<?= $hoy?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">Cantidad</td>
				<td class="c2"><input name="cantidad" type="text" size="5" value="<?= $cantidad?>"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c1">&nbsp;</td>
				<td class="c1">Costo U</td>
				<td class="c1"><input name="costo" type="text" size="5" value="<?= $costo?>"></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2">N° Prod.</td>
				<td class="c2"><input name="numero" type="text" size="15" value="<?= $numero?>"></td>
				<td class="c2">&nbsp;</td>
			</tr>
			<tr height="60">
				<td class="c1">&nbsp;</td>
				<td class="c1">Observaciones</td>
				<td class="c1"><textarea name="observaciones" rows="3" cols="50"><?= $observaciones?></textarea></td>
				<td class="c1">&nbsp;</td>
			</tr>
			<tr height="45">
				<td class="t" colspan="4" align="center">
					<a href="<?= $_SERVER['PHP_SELF']?>?volver=<?= date(d."-".m."-".Y.".:.".G.":".i.":".s)?>"><img src="images/b_back.png" border="0" alt="Volver"></a>&nbsp;&nbsp;
					<input type="image" src="images/b_insert.png" onClick="return confirm('Estás seguro que queres modificar el lote?');" title="Agregar el lote de produccion">
					<input type="hidden" name="modificar" value="ok">
					<input type="hidden" name="id_produccion" value="<?= $id_produccion?>">
					<input type="hidden" name="id_producto" value="<?= $id_producto?>">
					<input type="hidden" name="id_deposito" value="<?= $id_deposito?>">
				</td>
			</tr>
		</form>
	</table>
<? } // Cierro el if de si viene un id_produccion como para modificar?>


<?
if($ver == "listar"){

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
		<tr height="35"><td colspan="3" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=agregar"><img src="images/b_insert_new.png" border="0" alt="Insertar una nueva presentacion"></a></td></tr>
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
		$mes_s = " && month(fecha)=" . $mes;
		$fecha_d = '';
		$fecha_h = '';
	}
	if($ano > 0){ 
		$ano_s = "year(fecha)=" . $ano;
		$fecha_d = '';
		$fecha_h = '';
		if($mes > 0) $mes_s = $mes_s . " && ";
		if($mes == 0) $ano_s = " && ".$ano_s;
	}
	if($fecha_d != "")	$f = "&& fecha >= '$fecha_d' && fecha <= '$fecha_h'";
	if($f == "--") $f = "";
	
	$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
	while($rs_q = mysql_fetch_array($q_deposito)){
		$id_deposito = $rs_q['id_deposito'];
		$q = query("SELECT * FROM produccion WHERE id_deposito = $id_deposito $f $mes_s $ano_s");
		if(mysql_num_rows($q)>0){
		?>
		<br>	
		  <p align="center" class="titulo"><strong><?=$rs_q['deposito']?></strong></p>
	  <table width="700" align="center" cellpadding="0" cellspacing="0">
		  <tr height="30">
			<td width="15%" class="t" align="center">Fecha</td>
			<td width="55%" class="t" align="center">Producto</td>
			<td width="10%" class="t" align="center">Cant.</td>
			<td width="5%" class="t">&nbsp;</td>
			<td width="5%" class="t" align="center"><a href="imp_produccion.php?mes=<?= $mes?>&ano=<?= $ano?>&fecha_d=<?= $fecha_d?>&fecha_h=<?= $fecha_h?>" target="_blank" class="link_t" title="Imprimir la lista"><img src="images/b_print.png" border="0"></a></td>
		  </tr>
		  <?
			$cantidad_T = 0;
			$costo_T = 0; 		
			while($rs = mysql_fetch_array($q)){
				$id_producto = $rs['id_producto'];
				$id_produccion = $rs['id_produccion'];
			
				$qp = query("SELECT * FROM productos p 
							INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
							INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
							INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
							INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
							WHERE id_producto = $id_producto");
				$rp = mysql_fetch_array($qp);
				$categoria = $rp['categoria'];
				$linea = $rp['linea'];
				$variedad = " - ".$rp['variedad'];
				$sigla = $rp['sigla'];
				$presentacion = $rp['presentacion']." (".$rp['unidades']." x ". $rp['volumen']." ml.)";
				
				if($variedad == " - Todas") $variedad = "";
				
				$producto = $categoria." .:. ".$linea."".$variedad." - ". $presentacion;

				$fecha = $rs['fecha'];
				list($ano, $mes, $dia) = split( '[/.-]', $fecha);
				$ano = substr($ano, 2,2);
				$fecha = $dia."/".$mes."/".$ano;
				$cantidad = $rs['cantidad'];
				//$costo = $rs['costo'];
	
				$cantidad_T += $cantidad;
				//$costo_T += $costo * $cantidad; 
	
				$reg += 1;
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				?>
				<tr height="30">
					<td class="<?= $c?>" align="center"><?= $fecha?></td>
					<td class="<?= $c?>">&nbsp;<?= $producto?></td>
					<td class="<?= $c?>" align="right"><?= number_format($cantidad,0,',','.')?>&nbsp;&nbsp;</td>
					<td class="<?= $c?>" align="center"><a href="abm_produccion.php?ver=modificar&id_produccion=<?= $id_produccion?>"><img alt="Modificar/Ver detalle" name="img" src="images/b_edit.png" border="0"></a></td>
					<td class="<?= $c?>" align="center"><a href="abm_produccion.php?borrar=ok&id_produccion=<?= $id_produccion?>&id_producto=<?= $id_producto?>&id_deposito=<?= $id_deposito?>&cantidad=<?= $cantidad?>" onClick="return confirm('Estás seguro que queres eliminar este lote?');"><img alt="Eliminar el lote" name="img" src="images/b_no.png" border="0"></a></td>
				</tr>
			<? }?>
				<tr height="30">
					<td class="t">&nbsp;</td>
					<td class="t"><?= $x?></td>
					<td class="t" align="right"><?= number_format($cantidad_T, 0, ',', '.')?>&nbsp;&nbsp;</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center">&nbsp;</td>
				</tr>
		  </table>
		<br>
	  <? }?>
	<? }?>
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
