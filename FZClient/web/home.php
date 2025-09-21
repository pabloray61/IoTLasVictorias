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
$foto = "home";
$pag = "pag=hom";
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

<table width="80%" border="0" align="center"> 
	<tr>
		<td align="right">
			<?
			$sound_home = filemtime("sound_home.swf");
			$url_sound_home = "sound_home.swf?last_modified=" . date("Y-m-d-G:i:s", $sound_home);
			?>
				<script src="writeObject.js" language="JavaScript"></script>
				<script language="JavaScript" type="text/JavaScript">
					var strAux = '';
					strAux += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="20" height="20" align="top">';
						  strAux += '<param name="movie" value="<?=$url_sound_home?>"?>';
						  strAux += '<param name=quality value=high>';  
						  strAux += '<param name="LOOP" value="false">';
						  strAux += '<param name="menu" value="false">';
						  strAux += '<param name="bgcolor" value="#F7F0E0"/>';
						  strAux += '<embed src="<?=$url_sound_home?>" quality="high" bgcolor="#E5E8DF" width="20" height="20" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>';
					strAux += '</object>';
					writeObject(strAux);
				</script>				
		</td>
	</tr>
	<tr><td class="titulos">LA EMPRESA</td></tr>
	<tr height="15"><td></td></tr>
	<tr><td class="textos">Acordes nace en el año 2004 con el objetivo de elaborar y comercializar bebidas y productos alimenticios para su venta en el mercado local y de exportación.</td></tr>
	<tr height="10"><td></td></tr>
	<tr><td class="textos">Para ello ACORDES ha convocado a un grupo de profesionales en diferentes áreas que los une su pasión por el trabajo y la búsqueda de la excelencia.</td></tr>
	<tr height="10"><td></td></tr>
	<tr><td class="textos">La visión comercial de la empresa es desarrollar marcas que tengan estilo y que representen opciones de muy buena relación calidad/precio.  El desafío y la originalidad son una constante en nuestro proceso de creación.</td></tr>
	<tr height="10"><td></td></tr>
	<tr><td class="textos">Nuestros productos son comercializados a través de un equipo de venta especializada.</td></tr>
	<tr height="10"><td></td></tr>	
	<tr><td class="textos">Bienvenido a Acordes.</td></tr>
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
