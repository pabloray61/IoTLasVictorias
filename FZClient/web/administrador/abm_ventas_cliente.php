<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

	$iva = 1.21; // IVA ------------------------------------------------------------

$id_cliente = $_REQUEST['id_cliente'];

if($_REQUEST['Filtrar'] == "Filtrar"){
	if($_REQUEST['d_mes'] != "" and $_REQUEST['d_ano'] != ""){
		$filtro=" AND fecha >= '"  . $_REQUEST['d_ano'] . "-". $_REQUEST['d_mes'] . "-01'    ";
	}
	if($_REQUEST['h_mes'] != "" and $_REQUEST['h_ano'] != ""){		
		$filtro.=" AND (fecha <= '"  . $_REQUEST['h_ano'] . "-". $_REQUEST['h_mes'] . "-01' OR (year(fecha) = " . $_REQUEST['h_ano'] . " AND month(fecha) = ". $_REQUEST['h_mes'] ." )) ";
	}
//echo $filtro;

}
?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>

<script language="javascript" src="calendar1.js"></script>
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
if($mss_no != "") echo("<br><p class='error' align='center'>".$mss_no."</p><br>");
if($mss_ok != "") echo("<br><p class='bien' align='center'>".$mss_ok."</p><br>");
?>

<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr height="1">
    	<td width="1%"></td>
        <td width="98%" colspan="2"></td>
        <td width="1%"></td>
    </tr>
	<tr height="30"><td class="t" colspan="4" align="center">Historial</td></tr>
	<form method="post" name="formu" action="<?=$_SERVER['PHP_SELF']?>">
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">Seleccionar cliente:&nbsp;&nbsp;
			  <select name="id_cliente" onChange="formu.submit();">
					  <option value="">Seleccione un cliente</option>
					  <?
					  if($_SESSION['admin']=="ok") $q = query("SELECT * FROM clientes ORDER BY apellido, nombre");
					  if($_SESSION['admin']!="ok") $q = query("SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre");				  
					  while($rs = mysql_fetch_array($q)){
						  if($rs['nombre'] != "") $cliente = $rs['apellido'].", ".$rs['nombre'];
						  if($rs['nombre'] == "") $cliente = $rs['apellido'];
					  ?>
						<option value="<?=$rs['id_cliente']?>" <?  if($id_cliente == $rs['id_cliente']){ echo "SELECTED";} ?>><?= substr($cliente, 0, 30)?></option>
					  <? }?>
				  </select>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
	</form>
	<?
	if($id_cliente != ""){
		$q = query("SELECT c.apellido, c.nombre, c.id_vendedor, c.direccion, c.telefono, c.mail, c.celular, c.localidad, 
				   	v.nombre AS vendedor, v.telefono AS v_telefono
					FROM clientes c
					INNER JOIN vendedores v ON v.id_vendedor = c.id_vendedor
					WHERE id_cliente = $id_cliente");
		$rs = mysql_fetch_array($q);
		
		$apellido = $rs['apellido'];
		$nombre = $rs['nombre'];
		if($nombre != "") $cliente = $apellido.", ".$nombre;
		if($nombre == "") $cliente = $apellido;
		$id_vendedor = $rs['id_vendedor'];
		?>	
		<tr><td colspan="4"></td></tr>
		<tr height="30"><td class="t" colspan="4" align="center">Historial del Cliente <?= $cliente?></td></tr>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<table width="800" cellspacing="0" cellpadding="0" border="0">
				  <tr height="15"><td colspan="4"></td></tr>
				  <tr class="data">
					<td class="encabezado" width="15%">Nombre:</td>
					<td width="40%"><?= $cliente?></td>
					<td class="encabezado" width="15%">CUIT/DNI:</td>
					<td width="30%"><?= $rs['dni']?></td>
				  </tr>
				  <tr class="data">
					<td class="encabezado">Direccion:</td>
					<td><?= $rs['direccion']?></td>
					<td class="encabezado">Telefono:</td>
					<td><?= $rs['telefono']?></td>
				  </tr>
				  <tr class="data">
					<td class="encabezado">Mail:</td>
					<td><?= $rs['mail']?></td>
					<td class="encabezado">Celular:</td>
					<td><?= $rs['celular']?></td>
				  </tr>
				  <tr class="data">
					<td class="encabezado">Localidad:</td>
					<td><?= $rs['localidad']?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr height="15"><td colspan="4"></td></tr>
				</table>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
		<?
		$nombre = $rs['vendedor'];
		$telefono = $rs['v_telefono'];
		?>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<table width="600" cellspacing="0" cellpadding="0">
				  <tr height="15"><td colspan="4"></td></tr>
				  <tr class="data">
					<td class="encabezado" width="15%">Ejecutivo:</td>
					<td width="40%"><?= $nombre?></td>
					<td class="encabezado" width="15%">Telefono:</td>
					<td width="30%"><?= $telefono?></td>
				  </tr>
                </table>
            </td>
			<td class="c1">&nbsp;</td>
        </tr>
        <tr height="10"><td colspan="4" class="c1"></td></tr>
		<?
		$sql2="SELECT saldo,
		SUM(- case WHEN  (SELECT sum(monto) FROM pagos WHERE id_venta=v.id_venta)>0 THEN (SELECT sum(monto) FROM pagos WHERE id_venta=v.id_venta) ELSE 0 end + round(((SELECT SUM(cant*precio) FROM ventas_detalle vd WHERE vd.id_venta=v.id_venta AND regalo=0)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
		FROM ventas v 
		INNER JOIN clientes c on v.id_cliente=c.id_cliente
		WHERE c.id_cliente = $id_cliente
		GROUP BY c.id_cliente";
		//echo $sql2;
		$q2 = query($sql2);
		$rs2 = mysql_fetch_array($q2);
		?>
		<tr height="30"><td class="t" colspan="4" align="center">Pendiente de pago: $ <?= number_format($rs2['deuda'], 2, ',', '.')?></td></tr>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<table width="600" align="center" cellpadding="2" cellspacing="2">
				  <tr height="15"><td width="73"></td></tr>
				  <tr>
					<td width="10%" class="encabezado">Desde:</td>
					<td width="20%">
						<select name="d_mes">
						  <option value=""></option>
							<?
							$mes = $_REQUEST['d_mes'];
							$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
								for($i = 0; $i< sizeof($meses); $i++){
								?>
								  <option <? if($mes == $meses[$i]) {echo " SELECTED";} ?> value="<?= $i?>"><?= $meses[$i]?></option>
								<? }?>  
						</select>
					</td>
					<td width="10%">
						<select name="d_ano">
						  <option value=""></option>
							<?
							$ano=$_REQUEST['d_ano'];
							$hoy=getdate();
							for($a=2000;$a<=$hoy['year'];$a++){
							?>
							  <option <? if($ano==$a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
							<? }?>
						</select>
					</td>
					<td width="10%">&nbsp;</td>
					<td width="10%" class="encabezado">Hasta</td>
					<td width="20%">
					  <select name="h_mes">
						<option value=""></option>
						<? 
							$mes=$_REQUEST['h_mes'];
							$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
								for($i = 0; $i< sizeof($meses); $i++){
								?>
								  <option <? if($mes == $meses[$i]) {echo " SELECTED";} ?> value="<?= $i?>"><?= $meses[$i]?></option>
								<? }?>  
					  </select>
					</td>
					<td width="10%">
						<select name="h_ano">
						  <option value=""></option>
						  <?
						  $ano=$_REQUEST['h_ano'];
							$hoy=getdate();
							for($a=2000;$a<=$hoy['year'];$a++){
							?>
						  <option <? if($ano==$a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
						  <? }?>
						</select>
					</td>
					<td width="10%">
						<input type="hidden" name="id_cliente" value="<?=$id_cliente?>">
						<input type="submit" name="Filtrar" value="Filtrar">
					</td>
				  </tr>
				</table>
				</form>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
				  <tr height="50">
					<td class="encabezado" width="7%" align="center" title="Fecha de Pedido">Fecha<br>Pedido</td>
                    <td class="encabezado" width="7%" align="center">Numero<br>Pedido</td>
					<td class="encabezado" width="7%" align="center" title="Fecha del Remito">Fecha<br>Remito</td>
                    <td class="encabezado" width="11%" align="center">Numero<br>Remito</td>
					<td class="encabezado" width="7%" align="center" title="Fecha de Facturacion">Fecha<br>Factura</td>
                    <td class="encabezado" width="11%" align="center">Numero<br>Factura</td>
					<td class="encabezado" width="7%" align="center">Fecha<br>Pagado</td>
                    <td class="encabezado" width="5%" align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;">Dias de pago</td>
					<td class="encabezado" width="4%" align="center">Cajas</td>
					<td class="encabezado" width="4%" align="center">Bot</td>
					<td class="encabezado" width="4%" align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;">Bonif</td>
					<td class="encabezado" width="6%" align="center">Monto</td>
                    <td class="encabezado" width="6%" align="center">Cobro</td>
                    <td class="encabezado" width="6%" align="center">Saldo</td>
					<td class="encabezado" width="8%"></td>
				  </tr>
                  <tr height="1"><td colspan="15" bgcolor="#666666"></td></tr>
				<?
				$sql="SELECT id_venta, fecha, clientes.id_cliente, f_remito, f_factura, n_remito, n_factura,
					floor((UNIX_TIMESTAMP((select max(fecha) from pagos p where p.id_venta = v.id_venta)) - UNIX_TIMESTAMP(fecha)) / 86400) AS dias, 
					(select max(fecha) from pagos p where p.id_venta = v.id_venta) as fpago, 
					(select sum(monto) from pagos p where p.id_venta = v.id_venta) as pago, 
					round(((SELECT sum(cant*precio) from ventas_detalle vd where vd.id_venta = v.id_venta AND regalo=0)*(1-dto_porc/100) - dto_fijo)*100)/100 as monto, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto = vd.id_producto 
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE vd.id_venta = v.id_venta AND pp.presentacion = 'caja' AND regalo=0) as cajas, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto=vd.id_producto
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
						WHERE vd.id_venta=v.id_venta AND pp.presentacion != 'caja' AND pp.presentacion != 'botella' AND regalo=0) as items, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto=vd.id_producto 
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE vd.id_venta=v.id_venta AND pp.presentacion = 'botella' AND regalo=0) as botellas, v.id_vendedor 
					FROM ventas v 
					INNER JOIN clientes on clientes.id_cliente = v.id_cliente 
					WHERE v.id_cliente=". $id_cliente . " ". $filtro."  
					ORDER BY fecha DESC";
				//echo($sql."<br>");
				
				$q = query($sql);
				
				$cajas = 0;
				$bot = 0;
				$bonif = 0;
				$monto = 0;
				while($rs = mysql_fetch_array($q)){
					$monto = $rs['monto'];
					if($monto > 0){
						$cajas = $rs['cajas'];
						$bot = $rs['botellas'];
						$bonif = $rs['items'];
						$pago = $rs['pago'];
						$saldo = $monto-$pago;
	
						$dias = $rs['dias'];
	
						if($cajas == "") $cajas = "-";
						if($bot == "") $bot = "-";
						if($bonif == "") $bonif = "-";
					
						// TOTALES
							$cajas_T += $rs['cajas'];
							$bot_T += $rs['botellas'];
							$bonif_T += $rs['items'];
							$monto_T += $rs['monto'];
							$pago_T += $rs['pago'];
							$saldo_T += $rs['monto'] - $rs['pago'];
	
						// Le agrego ceros al nro de NP
							$id_v = $rs['id_venta'];
							$largo = strlen($id_v);
							$ceros = 8 - $largo;
							$num = "";
							for($ic = 0; $ic < $ceros; $ic++){
								$num = $num."0"; 
							}
							$nro_NP = $num."".$id_v;
						// -----------------
						
						$n_remito = $rs['n_remito'];
						$f_remito = rotarFecha($rs['f_remito']);
						$n_factura = $rs['n_factura'];
						$f_factura = rotarFecha($rs['f_factura']);
						
						?>  
                          <tr class="data" height="40">
                            <td align="center"><?= formatoFecha($rs['fecha'])?></td>
                            <td align="center"><?= $nro_NP?></td>
                            <td align="center"><?= empty($f_remito) ? "-" : $f_remito?></td>
                            <td align="center"><?= empty($n_remito) ? "-" : $n_remito?></td>
                            <td align="center"><?= empty($f_factura) ? "-" : $f_factura?></td>
                            <td align="center"><?= empty($n_factura) ? "-" : $n_factura?></td>
                            <td align="center"><?= $pago == $monto ? formatoFecha($rs['fpago']) : "<center> - </center>"?></td>
                            <td align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;">&nbsp;<?= $dias?>&nbsp;</td>
                            <td align="center"><?= $cajas?></td>
                            <td align="center"><?= $bot?></td>
                            <td align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;">&nbsp;<?= $bonif?>&nbsp;</td>
                            <td align="center">$<?= number_format($monto, 2, ",", ".")?></td>
                            <td align="center">$<?= number_format($pago, 2, ",", ".")?></td>
                            <td align="center">$<?= number_format($saldo, 2, ",", ".")?></td>
                            <td align="center">
                                <a href="ventas_detalle.php?id_cliente=<?= $rs['id_cliente']?>&id_venta=<?= $rs['id_venta']?>&Ver Detalle" title="Ver la venta">
                                <img src="images/b_ver.png" border="0">
                                </a>
                                <a href="abm_cobranzas.php?id_cliente=<?= $rs['id_cliente']?>" title="Ver el Pago">
                                <img src="images/b_pago.png" border="0">
                                </a>
                            </td>
                          </tr>  
					  <?
					  }
				}
				?>
				<tr height="1"><td colspan="15" bgcolor="#666666"></td></tr>
				  <tr class="data" height="30">
					<td colspan="7">&nbsp;</td>
					<td align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;"><b>Totales</b></td>
					<td align="center"><b><?=$cajas_T?></b></td>
					<td align="center"><b><?=$bot_T?></b></td>
					<td align="center" style="border-right-color:#999999; border-right-style:groove; border-right-width:thin;"><b><?=$bonif_T?></b></td>
					<td align="center"><b>$<?=number_format($monto_T,2,',','.')?></b></td>
                    <td align="center"><b>$<?=number_format($pago_T,2,',','.')?></b></td>
                    <td align="center"><b>$<?=number_format($saldo_T,2,',','.')?></b></td>
					<td>&nbsp;</td>
				  </tr>
				</table>
				
				<br>
				<table align="center" width="500" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="right">
						<a href="print_historial.php?id_cliente=<?=$_REQUEST['id_cliente']?>&d_mes=<?=$_REQUEST['d_mes']?>&h_mes=<?=$_REQUEST['h_mes']?>&d_ano=<?=$_REQUEST['d_ano']?>&h_ano=<?=$_REQUEST['h_ano']?>">
						<img src="images/imprimir.png" border="0" align="Planilla para Imprimir">
						</a>
                    </td>
				  </tr>
				</table>			
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
	<? }?>
	<tr height="20"><td colspan="4" class="t"></td></tr>
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
