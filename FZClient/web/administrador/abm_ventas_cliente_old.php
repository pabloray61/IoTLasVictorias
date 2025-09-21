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

<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="30%">AGENTE: <?=$_SESSION['nombre_vend']?></td>
		<td width="60%" align="right"></td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr><td colspan="4"></td></tr>
	<tr height="30"><td class="t" colspan="4" align="center">Historial del Cliente <?= $nombre?></td></tr>
	<form method="post" name="formu" action="<?=$_SERVER['PHP_SELF']?>">
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">Seleccionar cliente:&nbsp;&nbsp;
			  <select name="id_cliente" onChange="formu.submit();">
					  <option>Seleccione un cliente</option>
					  <?
					  if($_SESSION['admin']=="ok") $q = query("SELECT * FROM clientes ORDER BY apellido, nombre");
					  if($_SESSION['admin']!="ok") $q = query("SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre");				  
					  while($rs = mysql_fetch_array($q)){
					  ?>
						<option value="<?=$rs['id_cliente']?>" <?  if($id_cliente == $rs['id_cliente']){ echo "SELECTED";} ?>><?= substr($rs['apellido'].", ".$rs['nombre'], 0, 30)?></option>
					  <? }?>
				  </select>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
	</form>
	<?
	if($id_cliente != ""){
		$q = query("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
		$rs = mysql_fetch_array($q);
		$apellido = $rs['apellido'];
		$nombre = $rs['nombre'];
		?>	
		<tr><td colspan="4"></td></tr>
		<tr height="30"><td class="t" colspan="4" align="center">Historial del Cliente <?= $nombre?></td></tr>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<table width="546" cellspacing="2" cellpadding="2">
				  <tr height="15"><td colspan="4"></td></tr>
				  <tr class="data">
					<td class="encabezado" width="13%">Nombre:</td>
					<td width="50%"><?= $apellido.", ".$nombre?></td>
					<td class="encabezado" width="13%">CUIT/DNI:</td>
					<td width="24%"><?= $rs['dni']?></td>
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
		$sql2="SELECT saldo,
		SUM(- case WHEN  (select sum(monto) from pagos where id_venta=v.id_venta)>0 THEN (select sum(monto) from pagos where id_venta=v.id_venta) ELSE 0 end + round(((select sum(cant*precio) from ventas_detalle vd where vd.id_venta=v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100) as deuda
		FROM ventas v INNER JOIN clientes c on v.id_cliente=c.id_cliente
		WHERE c.id_cliente= $id_cliente
		GROUP BY c.id_cliente";
		//echo $sql2;
		$q2 = query($sql2);
		$rs2 = mysql_fetch_array($q2);
		?>
		<tr height="30"><td class="t" colspan="4" align="center">Pendiente de pago: $ <?=$rs2['deuda']?></td></tr>
		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">
				<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
				<table width="561" align="center" cellpadding="2" cellspacing="2">
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
				<table width="541" align="center" cellpadding="2" cellspacing="2">
				  <tr>
					<td class="encabezado" width="73">Fecha vta</td>
					<td class="encabezado" width="121" align="center">Fecha pago </td>
					<td class="encabezado" width="43" align="center">Cajas</td>
					<td class="encabezado" width="37" align="center">Bot</td>
					<td class="encabezado" width="48" align="center">Bonif</td>
					<td class="encabezado" width="50" align="right"><div align="right">Monto</div></td>
					<td class="encabezado" width="123"></td>
				  </tr>
				<?
				$sql="SELECT id_venta, fecha, clientes.id_cliente, 
					(select max(fecha) from pagos p where p.id_venta = v.id_venta) as fpago, 
					(select sum(monto) from pagos p where p.id_venta = v.id_venta) as pago, 
					round(((SELECT sum(cant*precio) from ventas_detalle vd where vd.id_venta = v.id_venta)*(1-dto_porc/100) - dto_fijo)*100)/100 as monto, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto = vd.id_producto 
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE vd.id_venta = v.id_venta AND pp.presentacion = 'caja') as cajas, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto=vd.id_producto
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
						WHERE vd.id_venta=v.id_venta AND pp.presentacion != 'caja' AND pp.presentacion != 'botella') as items, 
					(SELECT sum(cant) FROM ventas_detalle vd 
						INNER JOIN productos p ON p.id_producto=vd.id_producto 
						INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
						WHERE vd.id_venta=v.id_venta AND pp.presentacion = 'botella') as botellas, v.id_vendedor 
					FROM ventas v 
					INNER JOIN clientes on clientes.id_cliente = v.id_cliente 
					WHERE v.id_cliente=". $id_cliente . " ". $filtro."  
					ORDER BY fecha DESC";
				//echo($sql."<br>");
				$q = query($sql);
				
				$cajas=0;
				$bot=0;
				$bonif=0;
				$monto=0;
				while($rs = mysql_fetch_array($q)){
					$cajas = $rs['cajas'];
					$bot = $rs['botellas'];
					$bonif = $rs['items'];
					$monto = $rs['monto'];
				
					if($cajas == "") $cajas = "-";
					if($bot == "") $bot = "-";
					if($bonif == "") $bonif = "-";
				
				// TOTALES
					$cajas_T += $rs['cajas'];
					$bot_T += $rs['botellas'];
					$bonif_T += $rs['items'];
					$monto_T += $rs['monto'];
				
				
					$pago = $rs['pago'];
					$monto = $rs['monto'];
					
					if($monto > 0){
					?>  
					  <form action="ventas_detalle.php" method="post">
					  <tr class="data">
						<td><? formatoFecha($rs['fecha'])?></td>
						<td align="center"><? 
						if($pago == $monto){
							echo (formatoFecha($rs['fpago']));
						}elseif ($monto == 0){
							if($rs['visitas_tipo'] != ""){
								echo ($rs['visitas_tipo']);
							}else{
								echo("<center> - </center>");
							}
						}elseif($pago >0){
							echo ("$ " . $pago);
						}else{
							echo("<center> - </center>");
						}
						?></td>
						<td align="center"><?=$cajas?></td>
						<td align="center"><?=$bot?></td>
						<td align="center"><?=$bonif?></td>
						<td align="right"><div align="right">$<?= number_format($monto, 2, ",", ".")?></div></td>
						<td align="center">
						<input type="hidden" name="id_cliente" value="<?=$rs['id_cliente']?>">
						<input type="hidden" name="id_venta" value="<?=$rs['id_venta']?>">
						<input type="submit" value="Ver Detalle"></td>
					  </tr>
					  </form>
					  <?
					  }
				}
				?>
				
				  <tr class="data">
					<td>&nbsp;</td>
					<td align="center"><b>Totales</b></td>
					<td align="center"><b><?=$cajas_T?></b></td>
					<td align="center"><b><?=$bot_T?></b></td>
					<td align="center"><b><?=$bonif_T?></b></td>
					<td align="right"><b>$<?=number_format($monto_T,2,',','.')?></b></td>
					<td>&nbsp;</td>
				  </tr>
				</table>
				
				<br>
				<table align="center" width="500" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<form method="post" action="print_historial.php">
					  <div align="right">
						<input type="hidden" name="d_mes" value="<?=$_REQUEST['d_mes']?>">
						<input type="hidden" name="h_mes" value="<?=$_REQUEST['h_mes']?>">
						<input type="hidden" name="d_ano" value="<?=$_REQUEST['d_ano']?>">
						<input type="hidden" name="h_ano" value="<?=$_REQUEST['h_ano']?>">
						<input type="hidden" name="id_cliente" value="<?=$_REQUEST['id_cliente']?>">
				
						<input type="submit" value="Imprimir">
						</div>
					</form>
					
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
