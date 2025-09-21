<html>
<? 

$status="no";
$status = $_POST["status"];
$to = "valeria@acordessa.com";

$subject = ".: WEB ACORDES :.";
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$tel1 = $_POST["tel1"];
$mail = $_POST["mail"];
$comentario = $_POST["comentario"];

$message = "<p>Nombre: $nombre 
			<br>Apellido: $apellido
			<br>Teléfono: $tel1
			<br>E-Mail: $mail</p>";
$message .="<br><br><b>Comentario:</b> $comentario";

//echo("Message: ".$message);

$sender = $_POST["mail"];

$header = "From: $sender\nReply-To: $sender\nX-Mailer: PHP/" . phpversion() ."\nContent-type: text/html; charset=iso-8859-1\n";

if($status=="ok" && $_POST["boton"]== "Enviar"){
	if ($mail!=""){
		$send="ok";
	}
	else{
		$send="no";
	}
}

if($send=="ok"){
	$r = mail ($to, $subject, $message, $header);
	if($r){	
		$mail="ok";
	}
}
?>
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
$pag = "pag=con"; //3 letras
?>
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
	<tr class="titulos"><td>CONTACTO</td></tr>
	<tr height="15"><td></td></tr>
	<tr>
		<td>
		
			<?
			if($send=="ok" && $mail=="ok"){
				echo("<p align='center' class='send_ok'>El mensaje fue enviado correctamente</p>");
			}
			elseif ($send=="no" && $mail!="ok"){
				echo("<p align='center' class='send_no'>El mensaje no fue enviado, verifique que esten bien los datos</p>");
			}
			?>			

			<form name="form1" method="post" action="contacto.php">					  
			  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
				<tr><td class="sub-titulos">Para mayor información contáctenos por mail completando los siguientes campos.</td></tr>
				<tr height="15"><td></td></tr>
				<tr><td class="textos">Nombre</td></tr>
				<tr><td align="left"><input size="40" name="nombre" type="text" id="nombre" value="<?= $nombre?>"></div></td></tr>
				<tr height="10"><td></td></tr>
				<tr><td class="textos">Apellido</td></tr>
				<tr><td align="left"><input size="40" name="apellido" type="text" id="apellido" value="<?= $apellido?>"></div></td></tr>
				<tr height="10"><td></td></tr>											                         
				<tr><td class="textos">Tel&eacute;fono</td></tr>
				<tr><td align="left"><input size="40" name="tel1" type="text" id="tel12" value="<?= $tel1?>"></td></tr>
				<tr height="10"><td></td></tr>
				<tr><td class="textos">E-Mail</td></tr>
				<tr><td align="left"><input size="40" name="mail" type="text" id="mail2" value="<?= $mail?>"></td></tr>
				<tr height="10"><td></td></tr>
				<tr><td valign="top" class="textos">Comentarios</td></tr>
				<tr><td><textarea name="comentario" cols="31" rows="6" id="textarea"><?= $comentario?></textarea></td></tr>
				<tr height="5"><td></td></tr>
				<tr><td align="center"><input type="submit" name="boton" value="Enviar"><input type="hidden" name="status" value="ok"></td></tr>
			  </table>	
			</form>		
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
