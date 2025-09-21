<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

// INSERTAR O IMPRIMIR  //
$insertar = "ok";
//$imprimir = "ok";
//----------------------//

$fecha = $_REQUEST['fecha'];
	list($dia, $mes, $ano) = split( '[/.-]', $fecha);
	$fecha = $ano."-".$mes."-".$dia;

if ($_REQUEST["agregar"]=="ok" && $_REQUEST["cantidad_c"] != "" && $_REQUEST["cantidad_b"] != ""){

	$id_producto_c = $_REQUEST['id_producto_c'];
	$id_deposito = $_REQUEST['id_deposito'];
	$id_producto_b = $_REQUEST['id_producto_b'];
	$cant_c = $_REQUEST['cantidad_c'];
	$cant_b = $_REQUEST['cantidad_b'];

	$q_out = query("SELECT cantidad, id_stock FROM stock WHERE id_producto = $id_producto_c && id_deposito = $id_deposito");
	$rs_out = mysql_fetch_array($q_out);
	$q_in = query("SELECT cantidad FROM stock WHERE id_producto = $id_producto_b && id_deposito = $id_deposito");
	$rs_in = mysql_fetch_array($q_in);

	$id_s = $rs_out['id_stock']; 
	$c_out = $rs_out['cantidad']; 
	$c_in = $rs_in['cantidad'];

	if($c_out >= $cant_c){
		$sql =  "INSERT INTO abrir (id_abrir, id_producto_c, id_deposito, id_producto_b, fecha, cantidad_c, cantidad_b) VALUES (NULL, $id_producto_c, $id_deposito, $id_producto_b, '$fecha', $cant_c, $cant_b)";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");
// STOCK OUT		
		if($c_out == $cant_c){ // Si no esta cargado este producto en este deposito lo inserta normalmente.
			$sql_out = "DELETE FROM stock where id_producto = $id_producto_c && id_deposito = $id_deposito";
		}
		else{ // Si ya esta cargado este producto en este deposito solo agrega lo que se carga.
			$cant_out = $c_out - $cant_c;
			$sql_out = "UPDATE stock SET cantidad = $cant_out WHERE id_stock = $id_s";
		}
		if($insertar == "ok") mysql_query($sql_out, $conn_id);
		if($imprimir == "ok") echo($sql_out."<br>");
// STOCK IN
		if(mysql_num_rows($q_in) == 0){ // Si todavia no esta cargado este producto en este deposito lo inserto.
			$cant_in = $cant_c * $cant_b;
			$sql_in = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_producto_b, $id_deposito, $cant_in)";
		}
		else{  // Como ya esta cargado lo actualizo.
			$cant_in = $c_in + ($cant_b * $cant_c);
			$sql_in = "UPDATE stock SET cantidad = $cant_in where id_producto = $id_producto_b && id_deposito = $id_deposito";
		}
		if($insertar == "ok") mysql_query($sql_in, $conn_id);
		if($imprimir == "ok") echo($sql_in."<br>");
	}
	else{
		$msg = "No es posible generar esas botellas.<br>En el deposito seleccionado no existe dicha cantidad de cajas.";		
	}
}
elseif($_REQUEST["agregar"]=="ok"){
	$msg = "Debe ingresar la cantidad de cajas y la cantidad de botellas que posee.";		
}

if ($_REQUEST["borrar"] == 'ok'){
	$id_abrir = $_REQUEST['id_abrir'];
	$id_p_c = $_REQUEST['id_producto_c'];
	$id_p_b = $_REQUEST['id_producto_b'];
	$id_dep = $_REQUEST['id_deposito'];
	$cant_c = $_REQUEST['cantidad_c']; // cantidad nueva de CAJAS
	$cant_b = $_REQUEST['cantidad_b']; // cantidad nueva de BOTELLAS

	$qi = query("SELECT * FROM stock WHERE id_producto = $id_p_c && id_deposito = $id_dep");
	$ri = mysql_fetch_array($qi);
	$c_c = $ri['cantidad']; // cantidad q esta cargada en stock en CAJAS

	$qo = query("SELECT * FROM stock WHERE id_producto = $id_p_b && id_deposito = $id_dep");
	$ro = mysql_fetch_array($qo);
	$c_b = $ro['cantidad']; // cantidad q esta cargada en stock en BOTELLAS

//echo($cant_c." - ".$cant_b."<br>");
//echo($c_c." - ".$c_b."<br>");

	if($c_b > $cant_b){
		$sql = "DELETE FROM abrir where id_abrir = $id_abrir";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$cant_b = $c_b - $cant_b;
		$sql_i = "UPDATE stock SET cantidad = $cant_b where id_producto = $id_p_b && id_deposito = $id_dep";
		if($insertar == "ok") mysql_query($sql_i, $conn_id);
		if($imprimir == "ok") echo($sql_i."<br>");

		$cant_c = $c_c - $cant_c;		
		if($c_c > 0){
			$sql_o = "UPDATE stock SET cantidad = $cant_c where id_producto = $id_p_c && id_deposito = $id_dep";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");
		}
		else{
			$sql_o = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p_c, $id_dep, $cant_c)";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");		
		}
	}
	elseif($c_b == $cant_b){
		$sql = "DELETE FROM abrir where id_abrir = $id_abrir";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$sql2 = "DELETE FROM stock where id_producto = $id_p_b && id_deposito = $id_dep";
		if($insertar == "ok") mysql_query($sql2, $conn_id);
		if($imprimir == "ok") echo($sql2."<br>");

		$cant_c = $c_c - $cant_c;
		if($c_c > 0){
			$sql_o = "UPDATE stock SET cantidad = $cant_c where id_producto = $id_p_c && id_deposito = $id_dep";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");
		}
		else{
			$sql_o = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p_c, $id_dep, $cant_c)";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");		
		}
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

<p align="center" class="titulo">ABM Abrir Cajas </p>
<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr height="30"><td colspan="4" align="center" class="t">Agregar una Transferencia</td></tr>
		<form name="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="50">
				<td class="c1" width="5%">&nbsp;</td>
				<td class="c1" width="25%">Producto en Caja</td>
				<td class="c1" width="65%">
				<? 
				$q_producto = query("SELECT id_producto, concat(pc.categoria, ' - ', pl.linea, ' - ', pv.sigla, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
									FROM productos p
									INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
									INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
									INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE unidades > 1
									ORDER BY pc.orden, p.orden");
				?>
				<select name="id_producto_c" onChange="form.submit();">
					<option value="">--------></option>
					<? 
						while($rs_q = mysql_fetch_array($q_producto)){
							$id_p = $rs_q['id_producto'];
							$prod = $rs_q['producto'];
					?>
						<option value="<?= $id_p?>" <? if($id_p == $_REQUEST['id_producto_c']) echo("selected")?>><?= $prod?></option>
					<? }?>
				</select>	
				</td>
				<td class="c1" width="5%">&nbsp;</td>
			</tr>
		</form>
		<?
		if($_REQUEST['id_producto_c'] != ""){
			?>
			<form name="form2" action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<input type="hidden" name="id_producto_c" value="<?= $_REQUEST['id_producto_c']?>">
				<tr height="30">
					<td class="c2" width="5%">&nbsp;</td>
					<td class="c2" width="20%">Deposito</td>
					<td class="c2" width="70%">
						<? $q_deposito = query("SELECT * FROM depositos d INNER JOIN stock s ON d.id_deposito = s.id_deposito WHERE id_producto = ". $_REQUEST['id_producto_c'] ." GROUP BY deposito ORDER BY deposito");?>
						<select name="id_deposito" onChange="form2.submit();">
							<option value="">--------></option>
							<? while($rs_out = mysql_fetch_array($q_deposito)){?>
								<option value="<?=$rs_out['id_deposito']?>" <? if($rs_out['id_deposito'] == $_REQUEST['id_deposito']) echo("selected")?>><?=$rs_out['deposito']?></option>
							<? }?>
						</select>
					</td>
					<td class="c2" width="5%">&nbsp;</td>
				</tr>				
			</form>
			<?
			if($_REQUEST['id_deposito'] != ""){
				?>
				<form name="agregar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<input type="hidden" name="id_producto_c" value="<?= $_REQUEST['id_producto_c']?>">
					<input type="hidden" name="id_deposito" value="<?= $_REQUEST['id_deposito']?>">
					<tr>
					<tr height="40">
						<td class="c1" width="5%">&nbsp;</td>
						<td class="c1" width="20%">Producto generados</td>
						<td class="c1" width="70%">
							<? 
							$qpc = query("SELECT pc.categoria, pl.linea, pv.variedad, pp.volumen FROM productos p
											INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
											INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
											INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
											INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
											WHERE p.id_producto = ".$_REQUEST['id_producto_c']);
							$rsc = mysql_fetch_array($qpc);
							$q_botella = query("SELECT id_producto, concat(pc.categoria, ' - ', pl.linea, ' - ', pv.sigla, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
											FROM productos p
											INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
											INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
											INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
											INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
											WHERE unidades = 1
											 AND pc.categoria= '".$rsc['categoria']."'
											 AND pl.linea= '".$rsc['linea']."'
										  	 AND pv.variedad= '".$rsc['variedad']."'
										  	 AND pp.volumen= '".$rsc['volumen']."'
											ORDER BY pc.orden, p.orden");
							if(mysql_num_rows($q_botella)>0){
								?>
								<select name="id_producto_b">
									<option value="">--------></option>
									<? while($rs_in = mysql_fetch_array($q_botella)){?>
										<option value="<?=$rs_in['id_producto']?>" <? if($rs_in['id_producto'] == $_REQUEST['id_producto_b']) echo("selected")?>><?=$rs_in['producto']?></option>
									<? }?>
								</select>
							<? }else{?>
								No hay cargado ningun producto unitario con las caracteristicas de la caja. Carguelo el producto y luego vuelva a intentarlo.
							<? }?>
						</td>
						<td class="c1" width="5%">&nbsp;</td>
					</tr>
					<?
					$hoy = date(d."-".m."-".Y);
					?>
					<tr height="30">
						<td class="c2">&nbsp;</td>
						<td class="c2">Fecha</td>
						<td class="c2"><input name="fecha" type="text" size="10" value="<?= $hoy?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
						<td class="c2">&nbsp;</td>
					</tr>
					<tr height="30">
						<td class="c1">&nbsp;</td>
						<td class="c1">Cajas a abrir</td>
						<td class="c1"><input name="cantidad_c" type="text" size="5"></td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="50">
						<td class="t" colspan="4" align="center">
							<input type="image" src="images/b_insert.png" onClick="return confirm('Estás seguro que queres abrir esta caja?');" title="Abrir esta Caja">
							<input type="hidden" name="agregar" value="ok">
							<?
							$qu = query("SELECT unidades FROM productos p
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE id_producto =". $_REQUEST['id_producto_c']);
							$rsu = mysql_fetch_array($qu);
							$unidades = $rsu['unidades'];
							?>
							<input type="hidden" name="cantidad_b" value="<?= $unidades?>">
						</td>
					</tr>
				</form>
		<? }else{?>
			<tr height="20"><td colspan="4" class="t"></td></tr>
		<? }?>
	<? }else{?>
		<tr height="20"><td colspan="4" class="t"></td></tr>
	<? }?>
</table>
<br><br>
<p class="error" align="center"><?=$msg?></p>


<?
$qh = query("SELECT * FROM abrir");
if(mysql_num_rows($qh) > 0){ // ME FIJO SI HAY TRANSFERENCIAS CARGADAS

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
if($f == "WHERE fecha >= '--' && fecha <= '--'") $f = "";

$q = query("SELECT * FROM abrir $f $mes_s $ano_s");
if(mysql_num_rows($q)>0){
	?>
	<br>
	<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr height="30">
			<td width="2%" class="t"></td>
			<td width="7%" class="t" align="center">Fecha</td>
			<td width="29%" class="t" align="center">Producto en Caja</td>
			<td width="29%" class="t" align="center">Producto en Unidades</td>
			<td width="16%" class="t" align="center">Deposito</td>
			<td width="5%" class="t" align="center">C</td>
			<td width="5%" class="t" align="center">B</td>
			<td width="5%" class="t"></td>
			<td width="2%" class="t"></td>
		</tr>
	  <?
		$cantidad_T = 0;
		$costo_T = 0; 		
		while($rs=mysql_fetch_array($q)){
			$id_producto_c = $rs['id_producto_c'];
			$id_producto_b = $rs['id_producto_b'];
		// Producto en caja		
			$qp = query("SELECT id_producto, concat(pl.linea, ' - ', pv.sigla, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
									FROM productos p
									INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
									INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
									INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE id_producto = $id_producto_c
									ORDER BY pc.orden, p.orden");
			$rp = mysql_fetch_array($qp);
			$producto_c = $rp['producto'];

		// Producto en botellas		
			$qp = query("SELECT id_producto, concat(pl.linea, ' - ', pv.sigla, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
									FROM productos p
									INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
									INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
									INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									WHERE id_producto = $id_producto_b
									ORDER BY pc.orden, p.orden");
			$rp = mysql_fetch_array($qp);
			$producto_b = $rp['producto'];

		//DEPOSITO
			$id_deposito = $rs['id_deposito'];
			$qdo = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
			$rdo = mysql_fetch_array($qdo);
			$deposito = $rdo['deposito'];
			$deposito = substr($deposito, 0, 20).".";

			$fecha = $rs['fecha'];
			list($ano, $mes, $dia) = split( '[/.-]', $fecha);
			$ano = substr($ano, 2, 2);
			$fecha = $dia."/".$mes."/".$ano;

			$cantidad_c = -$rs['cantidad_c'];
			$cantidad_b = $rs['cantidad_b'] * $rs['cantidad_c'];

			$cantidad_T_C += $cantidad_c;
			$cantidad_T_B += $cantidad_b; 

			$reg += 1;
			$c = $flag ? "c1":"c2";
			$flag = !$flag;
			?>
			<tr height="30">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<td class="<?= $c?>">&nbsp;</td>
					<td class="<?= $c?>" align="center"><?= $fecha?></td>
					<td class="<?= $c?>">&nbsp;<?= $producto_c?></td>
					<td class="<?= $c?>">&nbsp;<?= $producto_b?></td>
					<td class="<?= $c?>" align="center">&nbsp;<?= $deposito?></td>
					<td class="<?= $c?>" align="center"><?= $cantidad_c?></td>
					<td class="<?= $c?>" align="center"><?= $cantidad_b?></td>
					<td class="<?= $c?>" align="center"><input type="image" name="img" src="images/b_no.png" onClick="return confirmar();"></td>
					<td class="<?= $c?>">&nbsp;</td>
					<input type="hidden" name="borrar" value="ok">
					<input type="hidden" name="id_abrir" value="<?= $rs['id_abrir']?>">
					<input type="hidden" name="id_producto_c" value="<?= $id_producto_c?>">
					<input type="hidden" name="id_producto_b" value="<?= $id_producto_b?>">
					<input type="hidden" name="id_deposito" value="<?=$rs['id_deposito']?>">
					<input type="hidden" name="cantidad_c" value="<?=$cantidad_c?>">
					<input type="hidden" name="cantidad_b" value="<?=$cantidad_b?>">
				</form>
			</tr>
		<? }?>
			<tr height="30">
				<td class="t" colspan="5">&nbsp;</td>
				<td class="t" align="center"><?= $cantidad_T_C?></td>
				<td class="t" align="center"><?= $cantidad_T_B?></td>
				<td class="t" colspan="2">&nbsp;</td>
			</tr>
	  </table>
	<br>
<? 
	} // CIERRO EL IF INTRNO
} // CIERRO SI NO HAY TRANSFERENCIAS HECHAS
?>

	<script language="javascript">
	var cal1 = new calendar1(document.forms['agregar'].elements['fecha']);
					cal1.year_scroll = true;
					cal1.time_comp = false;
	</script>

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
