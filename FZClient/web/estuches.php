<html><!-- InstanceBegin template="/Templates/web.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
$foto = $_REQUEST['ver'];
if($foto == "") $foto = "caja_1";

$pag = "pag=est";
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
	<tr height="20"><td></td></tr>
	<tr><td class="titulos">ESTUCHES</td></tr>
	<tr height="10"><td></td></tr>
	<tr>
		<td class="textos">
			Esta sección contiene una combinación de nuestros productos en presentaciones especiales preparados para ocasiones especiales y/o regalos empresariales. Asi se presentan desde cajas de regalo que incluyen copas de cristal grabadas con nuestros respectivos logos, estuches verticales cuyas combinación de productos es variada, hasta los propios estuches individuales de nuestros productos. <br>
			Los invitamos pues a seleccionar la combinación que mejor le vaya de acuerdo a la ocasión.
		</td>
	</tr>
	<tr height="10"><td></td></tr>
	<tr>
		<td align="center">
			<table width="98%" cellpadding="0" cellspacing="0" border="0">
				<tr height="10"><td colspan="2" class="sub-titulos">CAJAS</td></tr>
				<tr height="10"><td colspan="2"></td></tr>
				<tr valign="middle"><td width="50" align="center"><img src="images/ico_2.gif"></td><td class="sub-titulos"><a href="estuches.php?ver=caja_1" title="Caja Sinfonía">Caja Sinfonía</a></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr valign="middle"><td width="50" align="center"><img src="images/ico_3.gif"></td><td class="sub-titulos"><a href="estuches.php?ver=caja_2" title="Caja Saxo">Caja Saxo</a></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr valign="middle"><td width="50" align="center"><img src="images/ico_2.gif"><img src="images/ico_3.gif"></td><td class="sub-titulos"><a href="estuches.php?ver=caja_3" title="Caja Saxo">Caja Sinfonía-Saxo</a></td></tr>
			</table>
		</td>
	</tr>
	<tr height="10"><td></td></tr>
	<tr>
		<td align="center">
			<table width="98%" cellpadding="0" cellspacing="0" border="0">
				<tr height="10"><td colspan="2" class="sub-titulos">ESTUCHES</td></tr>
				<tr height="10"><td colspan="2"></td></tr>
				<tr valign="middle"><td width="50" align="center"><img src="images/ico_2.gif"></td><td class="sub-titulos"><a href="estuches.php?ver=estuche_1" title="Estuche Sinfonía">Estuche Sinfonía</a></td></tr>
				<tr height="5"><td colspan="2"></td></tr>
				<tr valign="middle"><td width="50" align="center"><img src="images/ico_3.gif"></td><td class="sub-titulos"><a href="estuches.php?ver=estuche_2" title="Estuche Saxo">Estuche Saxo</a></td></tr>				
			</table>
		</td>
	</tr>
	<tr height="10"><td></td></tr>	
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
