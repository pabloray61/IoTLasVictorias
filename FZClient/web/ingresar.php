<? 
require("administrador/conn.php");
require("administrador/func.php");

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if ($_REQUEST['boton'] == "Guardar" AND $_REQUEST['guardar'] == "datos"){
	$fecha_cumple = $_REQUEST['fecha_cumple'];
	if($fecha_cumple != ""){
		list($dia, $mes, $ano) = split( '[/.-]', $fecha_cumple);
		$fecha_cumple = "'".$ano."-".$mes."-".$dia."'";
	 }else{
	 	$fecha_cumple = 'NULL';
	 }
	
	$sql= "UPDATE clientes SET 
	apellido = '". $_REQUEST['apellido'] ."',
	nombre = '". $_REQUEST['nombre'] ."',
	sexo = '".$_REQUEST['sexo']."',
	telefono = '".$_REQUEST['telefono']."',
	mail = '".$_REQUEST['mail']."',
	direccion = '".$_REQUEST['direccion']."',
	dni = ".$_REQUEST['dni'].",
	pass = '".$_REQUEST['pass']."',
	cp = '".$_REQUEST['cp']."',
	celular = '".$_REQUEST['celular']."',
	localidad = '".$_REQUEST['localidad']."',
	fecha_cumple = $fecha_cumple,
	referente = '".$_REQUEST['referente']."'
	WHERE id_cliente = " . $_REQUEST['id_cliente'];

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);

	$msg = "<font class='send_ok'>Los datos se guardaron correctamente</font>";
}
if ($_REQUEST['boton'] == "Guardar" AND $_REQUEST['guardar'] == "referente"){
	$sql= "UPDATE clientes SET referente = '".$_REQUEST['referente']."'	WHERE id_cliente = " . $_REQUEST['id_cliente'];

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);

	$msg = "<font class='send_ok'>El referente se guardo correctamente</font>";
}
if ($_REQUEST['boton'] == "Guardar"){
	$ver = "";
}
?>
<html>
<!-- InstanceBegin template="/Templates/web.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

<title>.: Acordes -:- Selected Brands :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Acordes nace en el año 2003 con el objetivo de elaborar y comercializar bebidas y productos alimenticios para su venta en el mercado local y de exportación.">
<meta name="Classification" content="Sitio realizado en php con agregados en flash">
<meta name="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">
<meta http-equiv="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">

<link href="estilos.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
<?
$foto = "mantenimiento"; // nombre
$pag = "pag=ing"; //3 letras
?>
<script language="JavaScript" src="calendar1.js"></script>
<script language="javascript">
	function chequearPass(){
		//alert(formu.pass.value + " == " + formu.pass2.value);
		var pass = formu.pass.value;
		var pass2 = formu.pass2.value
		if(pass == pass2){
			ok.style.visibility = "visible"; 
		}else{
			ok.style.visibility = "hidden"; 
			formu.pass.value = "";
			formu.pass2.value = "";
			alert("Los valores ingresados no son iguales");
		}
	}
	function Abrir_ventana (pagina) {
		var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=530, height=220, top=85, left=140";
		window.open(pagina,"",opciones);
	}
</script>

<link rel="stylesheet" type="text/css" href="js/autocompletar.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
<!-- InstanceEndEditable -->
<?
if($foto == "registrate" OR $foto == "eventos" OR $foto == "lifestyle" OR $foto == "lugares" OR $foto == "compras"){
	$foto = "mantenimiento";
}
?>
</head>

<body bgcolor="#OOOOOO" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="800" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr valign="middle">
		<td>
			<table width="800" height="600" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr valign="top">
					<td><img src="images/foto_<?= $foto?>.jpg" width="475" height="528" alt=""></td>
					<td background="images/fdo_txt.jpg" width="325" height="528">
					  <!-- InstanceBeginEditable name="texto" -->

<?
$ver = $_REQUEST['ver'];
$id_cliente = $_REQUEST['id_cliente'];
$dni = $_REQUEST['dni'];
$pass = $_REQUEST['pass'];
if($dni != ""){
	$qi = query("SELECT * FROM clientes WHERE (dni= '$dni' OR cuit= '$dni') AND pass= '$pass'");	
	if(mysql_num_rows($qi) > 0){
		$rsi = mysql_fetch_array($qi);
		$id_cliente = $rsi['id_cliente'];
	}else{
		$msg = "Los datos ingresados son incorrectos.";
	}
}
//echo($dni." - ".$pass." - ".$id_cliente);
if($id_cliente != ""){
	$qc = query("SELECT * FROM clientes WHERE id_cliente = $id_cliente");	
	$rc = mysql_fetch_array($qc);
	$nombre = $rc['nombre']." ".$rc['apellido'];
	if($ver == ""){
		?>
			<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr height="10"><td colspan="6"></td></tr>
				<tr height="15"><td colspan="6" class="textos" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=&dni=">Log Out</a></td></tr>
				<tr height="10"><td colspan="6"></td></tr>
				<tr height="20"><td colspan="6" class="titulos">Bienvenido <?= $nombre?></td></tr>
				<tr height="30"><td colspan="6"></td></tr>
				<tr height="15"><td colspan="6"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=datos">Modificar mis datos</a></td></tr>
				<tr height="5"><td colspan="6"></td></tr>
				<tr height="15"><td colspan="6"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=historial">Ver mi historial</a></td></tr>
				<tr height="5"><td colspan="6"></td></tr>
				<tr height="15"><td colspan="6"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=referente">Referente / Recomendados</a></td></tr>
			</table>					
		<?
	}
	if($ver == "datos"){
		$q = query("SELECT * FROM clientes WHERE id_cliente= ". $id_cliente);
		$rs = mysql_fetch_array($q);
		$apellido = $ap = $rs['apellido'];
		$nombre = $no = $rs['nombre'];
		$sexo = $rs['sexo'];
		$telefono = $rs['telefono'];
		$mail = $rs['mail'];
		$web = $rs['web'];
		$direccion = $rs['direccion'];
		$id_tipo = $rs['id_tipo'];
		$id_categoria = $rs['id_categoria'];
		$id_lista = $rs['id_lista'];
		$dni = $rs['dni'];
		$cuit = $rs['cuit'];
		$cp = $rs['cp'];
		$contacto = $rs['contacto'];
		$celular = $rs['celular'];
		$observaciones = $rs['observaciones'];
		$compra = $rs['compra'];
		$factura = $rs['factura'];
		$localidad = $rs['localidad'];
		$id_grupo = $rs['id_grupo'];
		$fecha_alta = $rs['fecha_alta'];
		$referente = $rs['referente'];
		$fecha_cumple = $rs['fecha_cumple'];

			if($fecha_alta != ""){
				list($ano, $mes, $dia) = split( '[/.-]', $fecha_alta);
				$fecha_alta = $dia."-".$mes."-".$ano;
				if($fecha_alta == "--") $fecha_alta = "";
			}
			if($fecha_cumple != ""){
				list($ano, $mes, $dia) = split( '[/.-]', $fecha_cumple);
				$fecha_cumple = $dia."-".$mes."-".$ano;
				if($fecha_cumple == "--") $fecha_cumple = "";
				if($fecha_cumple == "00-00-0000") $fecha_cumple = "";
			}
		?>
		<form name="form" method="post" action="<?= $_SERVER['PHP_SELF']?>">
			<table width="90%" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr height="30"><td colspan="2"></td></tr>
				<tr height="20"><td colspan="2" class="titulos">Datos de <?= $nombre?></td></tr>
				<tr height="30"><td colspan="2"></td></tr>
				<tr><td class="textos">Nombre</td><td><input size="40" name="nombre" type="text" id="nombre" value="<?= $nombre?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Apellido</td><td><input size="40" name="apellido" type="text" id="apellido" value="<?= $apellido?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr>
					<td class="textos" colspan="2">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr valign="middle">
								<td width="15%" class="textos">Sexo</td>
								<td width="6%" class="textos" align="right">M</td>
								<td width="6%" class="textos"><input name="sexo" type="radio" value="1" <?= $sexo == 1 ? "checked" : "" ?>></td>
								<td width="6%" class="textos" align="right">F</td>
								<td width="6%" class="textos"><input name="sexo" type="radio" value="2" <?= $sexo == 2 ? "checked" : "" ?>></td>
								<td width="26%" class="textos" align="right">Fecha Nac&nbsp;</td>
								<td width="27%" class="textos" align="center"><input name="fecha_cumple" type="text" size="10" value="<?= $fecha_cumple?>" class="input">&nbsp;</td>
								<td width="8%" class="textos"><img src="images/cal.gif" onClick="javascript:cal.popup();"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">DNI</td><td><input size="40" name="dni" type="text" value="<?= $dni?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr>
					<td class="textos">Contraseña</td>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<? if($visibility == "") $visibility = "hidden";?>
								<td width="30%"><input size="10" name="pass" type="password" value="<?= $pass?>" class="input"></td>
								<td width="25%" align="center" class="textos">Repetir</td>
								<td width="30%"><input size="10" name="pass2" type="password" value="<?= $pass2?>" class="input" onChange="chequearPass();"></td>
								<td width="25%" align="center" style="visibility:<?= $visibility?>;" id="ok"><img src="images/ok.png" width="15"></td>							
							</tr>
						</table>
					</td>
				</tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Telefono</td><td><input size="40" name="telefono" type="text" value="<?= $telefono?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Celular</td><td><input size="40" name="celular" type="text" value="<?= $celular?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Mail</td><td><input size="40" name="mail" type="text" value="<?= $mail?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Direccion</td><td><input size="40" name="direccion" type="text" value="<?= $direccion?>" class="input"></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr>
					<td class="textos">Localidad</td>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="63%"><input size="25" name="localidad" type="text" value="<?= $localidad?>" class="input"></td>
								<td width="11%" align="center" class="textos">CP</td>
								<td width="26%"><input size="6" name="cp" type="text" value="<?= $cp?>" class="input"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height="25"><td></td></tr>
				<tr>
					<td align="center" colspan="2">
						<input type="submit" name="boton" value="Guardar">
						<input type="hidden" name="guardar" value="datos">
						<input type="submit" name="boton" value="Volver">
					</td>
				</tr>
			</table>
			<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
		</form>
		<script language="javascript">
			var cal = new calendar1(document.forms['formu'].elements['fecha_cumple']);
			cal.year_scroll = true;
			cal.time_comp = false;
		</script>
		<?
	}
	if($ver == "historial"){
		?>
		<table width="94%" border="0" align="center">
			<tr height="40">
				<td align="center">
					<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr height="15"><td colspan="6"></td></tr>
						<tr height="20"><td colspan="6" class="titulos">Historial de ventas</td></tr>
						<tr height="15"><td colspan="6"></td></tr>
						<tr height="20">
							<td class="sub-titulos" width="23%"><b>Fecha vta</b></td>
							<td class="sub-titulos" width="23%" align=	"center"><b>Fecha pago</b></td>
							<td class="sub-titulos" width="10%" align="center"><b>Cajas</b></td>
							<td class="sub-titulos" width="10%" align="center"><b>Bot</b></td>
							<td class="sub-titulos" width="10%" align="center"><b>Bonif</b></td>
							<td class="sub-titulos" width="24%" align="right"><div align="right">Monto</div></td>
						</tr>
				<?
				$q = query("SELECT id_venta, fecha, clientes.id_cliente, 
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
						WHERE v.id_cliente= $id_cliente
						ORDER BY fecha DESC");
					
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
							<tr height="20" class="textos">
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
									?>
								</td>
								<td class="textos" align="center"><?=$cajas?></td>
								<td class="textos" align="center"><?=$bot?></td>
								<td class="textos" align="center"><?=$bonif?></td>
								<td class="textos" align="right">$<?= $monto?></td>
							  </tr>
						  <?
						  }
					}
					?>
						<tr height="1"><td colspan="6" bgcolor="#000000"></td></tr>
						<tr class="data">
							<td>&nbsp;</td>
							<td class="textos_c" align="center"><b>Totales</b></td>
							<td class="textos_c" align="center"><b><?=$cajas_T?></b></td>
							<td class="textos_c" align="center"><b><?=$bot_T?></b></td>
							<td class="textos_c" align="center"><b><?=$bonif_T?></b></td>
							<td class="textos_c" align="right"><b>$<?=number_format($monto_T,2,',','.')?></b></td>
						</tr>
						<tr height="30"><td colspan="6"></td></tr>
						<tr><td colspan="6" class="textos_c" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=">Volver</a></td></tr>
					</table>
				</td>
			</tr>
		</table>
	<? 
	}
	if($ver == "referente"){
		$qrf = query("SELECT nombre, apellido, referente FROM clientes WHERE id_cliente= $id_cliente");
		$rf = mysql_fetch_array($qrf);
		$referente = $rf['referente'];
		$nombre = $rf['apellido'].", ".$rf['nombre'];
		$qrc = query("SELECT nombre, apellido FROM clientes WHERE referente= '$nombre' ORDER BY apellido, nombre");
		while($rc = mysql_fetch_array($qrc)){
			$apellido = $rc['apellido'];
			$nombre = $rc['nombre'];
			if($apellido !=	"" AND $nombre != "") $recomendados .= "&nbsp;&nbsp;&#8226;&nbsp;&nbsp;".$apellido.", ".$nombre."<br>";
			if($apellido !=	"" AND $nombre == "") $recomendados .= "&nbsp;&nbsp;&#8226;&nbsp;&nbsp;".$apellido."<br>";
			if($apellido ==	"" AND $nombre != "") $recomendados .= "&nbsp;&nbsp;&#8226;&nbsp;&nbsp;".$nombre."<br>";
		}
		//if($referente == "") $referente = "Aun no ha designado su referente.";
		if($recomendados == "") $recomendados = "Aun no se ha regisrado ningun recomendado.";
	?>
		<form name="formu" method="post" action="<?= $_SERVER['PHP_SELF']?>">
			<table width="94%" border="0" align="center">
				<tr height="40">
					<td align="center">
						<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr height="30"><td></td></tr>
							<tr height="20"><td class="titulos">Referente / Recomendados</td></tr>
							<tr height="30"><td></td></tr>
							<tr height="15"><td class="sub-titulos"><b>Referente</b></td></tr>
							<tr height="5"><td></td></tr>
							<tr><td><input class="input" size="30" type="text" id="referente" name="referente" value="<?= $referente?>" onkeyup="ajax_showOptions(this,'apellido',event)" autocomplete="off"></td></tr>
							<tr height="25"><td></td></tr>
							<tr height="15"><td class="sub-titulos"><b>Recomendados</b></td></tr>
							<tr height="5"><td></td></tr>
							<tr height="15"><td class="textos"><?= $recomendados?></td></tr>
							<tr height="20"><td></td></tr>
							<tr>
								<td align="center" colspan="2">
									<input type="submit" name="boton" value="Guardar">
									<input type="hidden" name="guardar" value="referente">
									<input type="submit" name="boton" value="Volver">
									<input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
								</td>
							</tr>
							<tr height="25"><td></td></tr>
							<tr height="15">
								<td>
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr valign="bottom">
											<td width="60%" class="sub-titulos">Recomendanos con tu amigos </td>
											<td width="40%"><a href="javascript:Abrir_ventana('recomendar.php')" title="Recomendar a tus amigos"><img src="images/b_mail.png" border="0"></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	<?
	}
}else{
?>
	<table width="90%" border="0" align="center"> 
		<tr height="15"><td></td></tr>
		<tr class="titulos"><td>INGRESAR</td></tr>
		<tr height="15"><td></td></tr>
		<tr>
			<td>
				<form name="formu" method="post" action="<?= $_SERVER['PHP_SELF']?>">					  
				  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
					<tr><td class="sub-titulos" colspan="2">Ingresa tus datos y mira tu historial.</td></tr>
					<tr height="15"><td colspan="2"></td></tr>
					<?
					if($msg != ""){
					?>
						<tr><td colspan="2" class="send_no"><?= $msg?></td></tr>
						<tr height="15"><td colspan="2"></td></tr>
					<? }?>
					<tr height="25"><td colspan="2"></td></tr>
					<tr>
						<td width="30%" class="textos">DNI</td>
						<td width="70%"><input size="15" name="dni" type="text" id="dni" value="<?= $dni?>" class="input"></td>
					</tr>
					<tr height="5"><td colspan="2"></td></tr>
					<tr><td class="textos">Contraseña</td><td><input size="15" name="pass" type="password" id="pass" value="<?= $pass?>" class="input"></td></tr>
					<tr height="15"><td colspan="2"></td></tr>
					<tr><td align="center" colspan="2"><input type="submit" name="boton" value="Ingresar"></td></tr>
				  </table>	
				</form>		
			</td>
		</tr>
	</table>
<? }?>
					  <!-- InstanceEndEditable -->		
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<?
					$menu = filemtime("menu.swf");
					$url_menu = "menu.swf?last_modified=" . date("Y-m-d-G:i:s", $menu);
					?>
						<script src="writeObject.js" language="JavaScript"></script>
						<script language="JavaScript" type="text/JavaScript">
							var strAux = '';
							strAux += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="800" height="72" align="top">';
								  strAux += '<param name="movie" value="<?=$url_menu?>"?>';
								  strAux += '<param name=quality value=high>';
								  strAux += '<param name=FlashVars value="<?= $pag?>">'					  
								  strAux += '<param name="LOOP" value="false">';
								  strAux += '<param name="menu" value="false">';
								  strAux += '<param name="bgcolor" value="#E5E8DF"/>';
								  strAux += '<embed src="<?=$url_menu?>" FlashVars="<?= $pag?>" quality="high" bgcolor="#E5E8DF" width="800" height="72" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>';
							strAux += '</object>';
							writeObject(strAux);
						</script>		
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
<!-- InstanceEnd --></html>
