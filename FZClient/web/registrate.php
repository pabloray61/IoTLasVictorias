<? 
require("administrador/conn.php");
require("administrador/func.php");

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if($_REQUEST['reg'] == "ok"){
	if($_REQUEST['dni'] != ""){
		//chequea si el cliente lo tiene otro vendedor
		$q = query("SELECT * FROM clientes WHERE dni = ".$_REQUEST['dni']);
		if(mysql_num_rows($q) == 0){
	
			//guarda los datos del form
			$poe = 1;
			$id_vendedor = 1;
			$apellido = $_REQUEST['apellido'];
			$nombre = $_REQUEST['nombre'];
			$sexo = $_REQUEST['sexo'];
			$telefono = $_REQUEST['telefono'];
			$mail = $_REQUEST['mail'];
			$web = 'NULL';
			$direccion = $_REQUEST['direccion'];
			$id_tipo = 1;
			$id_categoria = 1;
			$id_lista = 4;
			$dni = $_REQUEST['dni'];
			if($dni == "") $dni = 'NULL';
			$cuit = 'NULL';
			$pass = $_REQUEST['pass'];
			$cp = $_REQUEST['cp'];
			$contacto = 'NULL';
			$celular = $_REQUEST['celular'];
			$compra = 'NULL';
			$factura = 1;
			$observaciones = 'NULL';
			$localidad = $_REQUEST['localidad'];
			$fecha_alta = date("Y-m-d");
			$fecha_cumple = $_REQUEST['fecha'];	
			list($dia, $mes, $ano) = split( '[/.-]', $fecha_cumple);
			$fecha_cumple = $ano."-".$mes."-".$dia;
			$fecha = $fecha_cumple;
			$id_grupo = 7;
			$referente = $_REQUEST['referente'];
	
			if($sexo == "") $sexo = 0;
			if($cp == "") $cp = 0;
	
			if($fecha_alta == "--" OR $fecha_alta == "") $fecha_alta = "NULL";	
			if($fecha_cumple == "--" OR $fecha_cumple == "") $fecha_cumple = "NULL";
			if($fecha_alta != "NULL") $fecha_alta = "'$fecha_alta'";	
			if($fecha_cumple != "NULL") $fecha_cumple = "'$fecha_cumple'";
		
			$sql = "INSERT INTO clientes (id_cliente, poe, apellido, nombre, sexo, fecha_cumple, dni, cuit, pass, telefono, celular, mail, web,
					contacto, direccion, localidad, cp, id_tipo, id_categoria, id_lista, compra, factura, id_grupo, id_vendedor, fecha_alta, 
					referente, observaciones) VALUES (NULL, $poe, '$apellido', '$nombre', $sexo, $fecha_cumple, $dni, '$cuit', '$pass', 
					'$telefono', '$celular', '$mail', '$web', '$contacto', '$direccion', '$localidad', $cp, $id_tipo, $id_categoria, 
					$id_lista, NULL, '$factura', $id_grupo, $id_vendedor, $fecha_alta, '$referente', 
					'$observaciones')";
	
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: ".$sql);
	
			$msg = "<font class='send_ok'>Tus datos se guardaron correctamente</font>";
		}else{
			$msg = "<font class='send_no'>Ya estas registrado</font>";	
		}
	}else{
		$msg = "<font class='send_no'>El DNI es obligatorio.</font>";	
	}
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
$pag = "pag=reg"; //3 letras
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

<table width="90%" border="0" align="center"> 
	<tr height="15"><td></td></tr>
	<tr class="titulos"><td>REGISTRATE</td></tr>
	<tr height="15"><td></td></tr>
	<tr>
		<td>
			<form name="formu" method="post" action="<?= $_SERVER['PHP_SELF']?>">
			  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
				<tr><td class="sub-titulos" colspan="2">Registrate y se parte de la comunidad de Acordes.</td></tr>
				<tr height="15"><td colspan="2"></td></tr>
				<?
				if($msg != ""){
				?>
					<tr><td colspan="2"><?= $msg?></td></tr>
					<tr height="15"><td colspan="2"></td></tr>
				<? }?>
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
								<td width="6%" class="textos"><input name="sexo" type="radio" value="1"></td>
								<td width="6%" class="textos" align="right">F</td>
								<td width="6%" class="textos"><input name="sexo" type="radio" value="2"></td>
								<td width="26%" class="textos" align="right">Fecha Nac&nbsp;</td>
								<td width="27%" class="textos" align="center"><input name="fecha" type="text" size="10" value="<?= $fecha?>" class="input">&nbsp;</td>
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
				<tr height="10"><td colspan="2"></td></tr>
				<tr><td colspan="2" class="textos">Obtene beneficio recomendandonos a tus amigos.</td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr><td class="textos">Referente:</td><td><input class="input" size="30" type="text" id="referente" name="referente" value="<?= $referente?>" onkeyup="ajax_showOptions(this,'apellido',event)" autocomplete="off"></td></tr>
				<tr height="15"><td colspan="2"></td></tr>
				<tr><td align="center" colspan="2"><input type="submit" name="boton" value="Registrarme"><input type="hidden" name="reg" value="ok"></td></tr>
			  </table>	
			</form>		
			<script language="javascript">
				var cal = new calendar1(document.forms['formu'].elements['fecha']);
				cal.year_scroll = true;
				cal.time_comp = false;
			</script>
		</td>
	</tr>
</table>

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
