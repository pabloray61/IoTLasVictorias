<html><!-- InstanceBegin template="/Templates/sub_web.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
$foto = "";
$pag = "pag=vin";
?>
<!-- InstanceEndEditable -->
<?
if($foto == "novedades" OR $foto == "registrate" OR $foto == "eventos" OR $foto == "lifestyle" OR $foto == "lugares" OR $foto == "compras"){
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
					<td bgcolor="f9f2e2" width="800" height="528">
					  <!-- InstanceBeginEditable name="texto" -->
					  
<table width="95%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr valign="top">
    <td width="30%" align="center"><br><img src="images/vino_selected.jpg"></td>
	<td width="60%">
		<table width="100%" border="0">
			<tr height="10"><td></td></tr>
			<tr><td align="right"><img src="images/logo_sinfonia.jpg"></td></tr>
			<tr><td class="titulos">VINO SINFONIA - SELECTED VINEYARDS</td></tr>
			<tr height="5"><td></td></tr>
		  	<tr><td class="textos">Una línea de vinos con personalidad proveniente de añejos viñedos situados al pie de la Cordillera de los Andes y de un moderno proceso de elaboración. El objetivo de estos vinos son vinos jovenes con un muy pequeño toque de madera, para poder apreciar las variedades. Se presentan en tres variedades:</td></tr>
			<tr height="10"><td></td></tr>
			<tr><td class="sub-titulos">SINFONIA SV - MALBEC</td></tr>
			<tr height="5"><td></td></tr>
		  	<tr><td class="textos">De intenso color rojo rubí donde se destacan las notas de ciruela y frambuesa. Ideal para acompañar carnes rojas y pasta. Cosechas 2003, 2004 y 2006 - Alcohol: 13,5 % v/v</td></tr>
			<tr height="15"><td></td></tr>			
			<tr><td class="sub-titulos">SINFONIA SV - CABERNET SAUVIGNON </td></tr>
			<tr height="5"><td></td></tr>
		  	<tr><td class="textos">De intenso color rojo violáceo donde se destacan las notas de pimienta negra y chocolate. Ideal para acompañar carnes rojas y platos sazonados. Cosechas 2003, 3004 y 2006 - Alcohol: 13,5 % v/v</td></tr>
			<tr height="15"><td></td></tr>			
			<tr><td class="sub-titulos">SINFONIA SV - CHARDONNAY</td></tr>
			<tr height="5"><td></td></tr>
		  	<tr><td class="textos">De color amarillo con reflejos verdes donde se destacan las notas de ananá, manzana verde y frutos tropicales.  Ideal para acompañar carnes blancas, risotos y mariscos. Cosechas 2004 - Alcohol: 13,5 % v/v</td></tr>
			<tr height="20"><td></td></tr>	
		  	<tr><td class="sub-titulos" align="right"><a href="vinos.php">VOLVER</a></td></tr>
			<tr height="10"><td></td></tr>						
		</table>
	</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr valign="bottom"><td colspan="4"><img src="images/acordes_dw.jpg"></td></tr>
</table>

					  
					  <!-- InstanceEndEditable -->		
					</td>
				</tr>
				<tr>
					<td>
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
