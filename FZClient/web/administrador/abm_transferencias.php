<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

// INSERTAR O IMPRIMIR  //
$insertar = "ok";
//$imprimir = "ok";
//----------------------//

$fecha = rotarFecha($_REQUEST['fecha']);

if ($_REQUEST["agregar"] == "ok" and !empty($_REQUEST["cantidad"])){

	$id_p = $_REQUEST['id_producto'];
	$id_d_out = $_REQUEST['id_deposito_out'];
	$id_d_in = $_REQUEST['id_deposito_in'];
	$cant = $_REQUEST['cantidad'];
	$cos = preg_replace(',', '.', $_REQUEST['costo']);
	if($cos == "") $cos = 0;

	$q_out = query("SELECT cantidad, id_stock FROM stock WHERE id_producto = $id_p && id_deposito = $id_d_out");
	$rs_out = mysql_fetch_array($q_out);
	$q_in = query("SELECT cantidad FROM stock WHERE id_producto = $id_p && id_deposito = $id_d_in");
	$rs_in = mysql_fetch_array($q_in);

	$id_s = $rs_out['id_stock']; 
	$c_out = $rs_out['cantidad']; 
	$c_in = $rs_in['cantidad'];

	if($c_out >= $cant){
		$sql =  "INSERT INTO transferencia (id_transferencia, id_producto, id_deposito_out, id_deposito_in, fecha, cantidad, costo) VALUES (NULL, $id_p, $id_d_out, $id_d_in, '$fecha', $cant, $cos)";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");
// STOCK OUT		
		if($c_out == $cant){ // Si no esta cargado este producto en este deposito lo inserta normalmente.
			$sql_out = "DELETE FROM stock where id_producto = $id_p && id_deposito = $id_d_out";
		}
		else{ // Si ya esta cargado este producto en este deposito solo agrega lo que se carga.
			$cant_out = $c_out - $cant;
			$sql_out = "UPDATE stock SET cantidad = $cant_out WHERE id_stock = $id_s";
		}
		if($insertar == "ok") mysql_query($sql_out, $conn_id);
		if($imprimir == "ok") echo($sql_out."<br>");
// STOCK IN
		if(mysql_num_rows($q_in) == 0){ // Si todavia no esta cargado este producto en este deposito lo inserto.
			$sql_in = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p, $id_d_in, ". $_REQUEST['cantidad'].")";
		}
		else{  // Como ya esta cargado lo actualizo.
			$cant_in = $c_in + $cant;
			$sql_in = "UPDATE stock SET cantidad = $cant_in where id_producto = $id_p && id_deposito = $id_d_in";
		}
		if($insertar == "ok") mysql_query($sql_in, $conn_id);
		if($imprimir == "ok") echo($sql_in."<br>");
	}
	else{
		$msg = "No es posible realizar esta transferencia.<br>En el deposito seleccionado no existe esa cantidad de ese producto.";		
	}
}

if ($_REQUEST["borrar"] == 'ok'){
	$id_transferencia = $_REQUEST['id_transferencia'];
	$id_p = $_REQUEST['id_producto'];
	$id_d_o = $_REQUEST['id_deposito_out'];
	$id_d_i = $_REQUEST['id_deposito_in'];
	$cant = $_REQUEST['cantidad'];

	$qi = query("SELECT * FROM stock WHERE id_producto = $id_p && id_deposito = $id_d_i");
	$ri = mysql_fetch_array($qi);
	$c_i = $ri['cantidad'];

	$qo = query("SELECT * FROM stock WHERE id_producto = $id_p && id_deposito = $id_d_o");
	$ro = mysql_fetch_array($qo);
	$c_o = $ro['cantidad'];

	if($c_i > $cant){
		$sql = "DELETE FROM transferencia where id_transferencia = $id_transferencia";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$cant_i = $c_i - $cant;
		$sql_i = "UPDATE stock SET cantidad = $cant_i where id_producto = $id_p && id_deposito = $id_d_i";
		if($insertar == "ok") mysql_query($sql_i, $conn_id);
		if($imprimir == "ok") echo($sql_i."<br>");
		
		if($c_o > 0){
			$cant_o = $c_o + $cant;
			$sql_o = "UPDATE stock SET cantidad = $cant_o where id_producto = $id_p && id_deposito = $id_d_o";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");
		}
		else{
			$sql_o = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p, $id_d_o, $c_o)";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");		
		}
	}
	elseif($c_i == $cant){
		$sql = "DELETE FROM transferencia where id_transferencia = $id_transferencia";
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo($sql."<br>");

		$sql2 = "DELETE FROM stock where id_producto = $id_p && id_deposito = $id_d_i";
		if($insertar == "ok") mysql_query($sql2, $conn_id);
		if($imprimir == "ok") echo($sql2."<br>");

		if($c_o > 0){
			$cant_o = $c_o + $cant;
			$sql_o = "UPDATE stock SET cantidad = $cant_o where id_producto = $id_p && id_deposito = $id_d_o";
			if($insertar == "ok") mysql_query($sql_o, $conn_id);
			if($imprimir == "ok") echo($sql_o."<br>");
		}
		else{
			$sql_o = "INSERT INTO stock (id_stock, id_producto, id_deposito, cantidad) VALUES (NULL, $id_p, $id_d_o, $c_o)";
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

<p align="center" class="titulo">ABM Transferencias</p>
<?
	// Productos
	$q_producto = query("SELECT id_producto, categoria, linea, sigla, presentacion, unidades, volumen FROM productos p
						INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
						INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
						INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						ORDER BY pc.orden, p.orden");
	// Depositos
	$q_deposito = query("SELECT * FROM depositos ORDER BY deposito");
?>

<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr height="30"><td colspan="4" align="center" class="t">Agregar una Transferencia</td></tr>
		<form name="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<tr height="50">
				<td class="c1" width="5%">&nbsp;</td>
				<td class="c1" width="20%">Producto</td>
				<td class="c1" width="70%">
					<select name="id_producto" onChange="form.submit();">
						<option value="">--------></option>
						<? 
						while($rs_q = mysql_fetch_array($q_producto)){
							$producto = $rs_q['categoria']." ".$rs_q['linea']." - ". $rs_q['sigla']." ".$rs_q['presentacion']." (".$rs_q['unidades']."x".$rs_q['volumen'].")";
							?>
							<option value="<?=$rs_q['id_producto']?>" <? if($rs_q['id_producto'] == $_REQUEST['id_producto']) echo("SELECTED")?>><?= $producto?></option>
						<? }?>
					</select>	
				</td>
				<td class="c1" width="5%">&nbsp;</td>
			</tr>
		</form>
		<?
		if($_REQUEST['id_producto'] != ""){
			?>
			<form name="agregar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<input type="hidden" name="id_producto" value="<?= $_REQUEST['id_producto']?>">
				<tr height="30">
					<td class="c2">&nbsp;</td>
					<td class="c2">Deposito Out</td>
					<td class="c2">
						<? $q_deposito = query("SELECT * FROM depositos d INNER JOIN stock s ON d.id_deposito = s.id_deposito WHERE id_producto = ". $_REQUEST['id_producto'] ." GROUP BY deposito ORDER BY deposito");?>
						<select name="id_deposito_out">
							<option value="">--------></option>
							<? while($rs_out = mysql_fetch_array($q_deposito)){?>
								<option value="<?=$rs_out['id_deposito']?>"><?=$rs_out['deposito']?></option>
							<? }?>
						</select>
					</td>
					<td class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td class="c1">&nbsp;</td>
					<td class="c1">Deposito In</td>
					<td class="c1">
						<? $q_deposito = query("SELECT * FROM depositos ORDER BY deposito");?>
						<select name="id_deposito_in">
							<option value="">--------></option>
							<? while($rs_in = mysql_fetch_array($q_deposito)){?>
								<option value="<?=$rs_in['id_deposito']?>"><?=$rs_in['deposito']?></option>
							<? }?>
						</select>
					</td>
					<td class="c1">&nbsp;</td>
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
					<td class="c1">Cantidad</td>
					<td class="c1"><input name="cantidad" type="text" size="5" onChange="actualizarCosto();"></td>
				  	<td class="c1">&nbsp;</td>
				</tr>
				<tr height="30">
				  	<td class="c2">&nbsp;</td>
					<td class="c2">Costo Flete</td>
					<td class="c2"><input name="flete" type="text" size="5" onChange="actualizarCosto();"></td>
				  	<td class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td class="c1">&nbsp;</td>
					<td class="c1">$ x caja --></td>
					<td class="c1">$&nbsp;<input name="costo" type="text" size="5" value="<?= number_format($costo, 2, ',', '.')?>" readonly="" style="border-style:none; border-color:#FFFFFF"></td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="t" colspan="4" align="center">
						<input type="image" src="images/b_insert.png" onClick="return confirm('Estás seguro que queres generar esta transferencia?');" title="Agregar una transferencia">
						<input type="hidden" name="agregar" value="ok">
					</td>
				</tr>
			</form>
		<? }else{?>
			<tr height="20"><td colspan="4" class="t"></td></tr>
		<? }?>
</table>
<br><br>
<p class="error" align="center"><?=$msg?></p>


<?
$qh = query("SELECT * FROM transferencia");
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
				$fecha_h = rotarFecha($fecha_hasta);
				$fecha_d = rotarFecha($fecha_desde);
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
	if($f == "--") $f = "";
	
		$q = query("SELECT * FROM transferencia $f $mes_s $ano_s");
		if(mysql_num_rows($q)>0){
	?>
	<br>
	<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr height="30">
			<td width="2%" class="t"></td>
			<td width="7%" class="t" align="center">Fecha</td>
			<td width="33%" class="t" align="center">Producto</td>
			<td width="20%" class="t" align="center">Deposito Out</td>
			<td width="20%" class="t" align="center">Deposito In</td>
			<td width="6%" class="t" align="center">Cant</td>
			<td width="8%" class="t" align="center">Costo</td>
			<td width="3%" class="t"></td>
			<td width="2%" class="t"></td>
		</tr>
	  <?
		$cantidad_T = 0;
		$costo_T = 0; 		
		while($rs=mysql_fetch_array($q)){
			$id_producto = $rs['id_producto'];
		
			$qp = query("SELECT pl.linea, pv.sigla, pp.presentacion, pp.unidades, pp.volumen FROM productos p 
							INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
							INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
							INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
							INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
							WHERE id_producto = $id_producto");
			$rp = mysql_fetch_array($qp);
				$linea = $rp['linea'];
				$sigla = " - ".$rp['sigla'];
				$presentacion = $rp['presentacion']." (".$rp['unidades']." x ". $rp['volumen']." ml.)";
				
				if($variedad == " - Todas") $sigla = "";
				$producto = $linea."".$sigla." - ". $presentacion;
				
		//DEPOSITO OUT
			$id_d_o = $rs['id_deposito_out'];
			$qdo = query("SELECT * FROM depositos WHERE id_deposito = $id_d_o");
			$rdo = mysql_fetch_array($qdo);
			$dep_out = $rdo['deposito'];
			$dep_out = substr($dep_out, 0, 20);

		//DEPOSITO IN
			$id_d_i = $rs['id_deposito_in'];
			$qdi = query("SELECT * FROM depositos WHERE id_deposito = $id_d_i");
			$rdi = mysql_fetch_array($qdi);
			$dep_in = $rdi['deposito'];
			$dep_in = substr($dep_in, 0, 20);

			$fecha = $rs['fecha'];
			list($ano, $mes, $dia) = preg_split( '[-]', $fecha);
			$ano = substr($ano, 2, 2);
			$fecha = $dia."/".$mes."/".$ano;
			$cantidad = $rs['cantidad'];
			$costo = $rs['costo'];

			$cantidad_T += $cantidad;
			$costo_T += $costo; 

			$reg += 1;
			$bg = $flag ? "c1":"c2";
			$flag = !$flag;
			?>
			<tr height="30">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<td class="<?= $bg?>">&nbsp;</td>
					<td class="<?= $bg?>" align="center"><?= $fecha?></td>
					<td class="<?= $bg?>">&nbsp;<?= $producto?></td>
					<td class="<?= $bg?>" align="center">&nbsp;<?= $dep_out?></td>
					<td class="<?= $bg?>" align="center">&nbsp;<?= $dep_in?></td>
					<td class="<?= $bg?>" align="center"><?= $cantidad?></td>
					<td class="<?= $bg?>" align="center"><?= $costo?></td>
					<td class="<?= $bg?>" align="center"><input type="image" name="img" src="images/b_no.png" onClick="return confirm('Estás seguro que queres eliminar esta transferencia?');"></td>
					<td class="<?= $bg?>">&nbsp;</td>
					<input type="hidden" name="borrar" value="ok">
					<input type="hidden" name="id_transferencia" value="<?= $rs['id_transferencia']?>">
					<input type="hidden" name="id_producto" value="<?= $id_producto?>">
					<input type="hidden" name="id_deposito_out" value="<?=$rs['id_deposito_out']?>">
					<input type="hidden" name="id_deposito_in" value="<?=$rs['id_deposito_in']?>">
					<input type="hidden" name="cantidad" value="<?=$cantidad?>">
				</form>
			</tr>
		<? }?>
			<tr height="30">
				<td class="t" colspan="5">&nbsp;</td>
				<td class="t" align="center"><?= $cantidad_T?></td>
				<td class="t" align="center"><?= number_format($costo_T, 2, ',', '.')?></td>
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
