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
$pag = "pag=esp";
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
    <td width="25%" align="center"><br><img src="images/champagne_saxo_355.jpg"></td>
	<td width="60%">
		<table width="100%" border="0">
			<tr height="100"><td></td></tr>
			<tr><td class="titulos">CHAMPAGNE SAXO 355</td></tr>
			<tr height="30"><td></td></tr>
		  	<tr><td class="textos">Partiendo del champagne SAXO, se desarrolló un concepto nuevo en presentación utilizando un formato de botella de cerveza de 355 ml, una etiqueta full body y tapa corona.</td></tr>
			<tr height="10"><td></td></tr>
		  	<tr><td class="textos">El concepto se probó durante la fiestas y verano 2007/2008 y está listo para el lanzamiento y comercialización durante el año 2008.</td></tr>
			<tr height="10"><td></td></tr>
		  	<tr><td class="textos">Ideal para ocaciones informales y fiestas.  </td></tr>
			<tr height="40"><td></td></tr>	
		  	<tr><td class="sub-titulos" align="right"><a href="espumantes.php">VOLVER&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
			<tr height="10"><td></td></tr>						
		</table>
	</td>
    <td width="15%" align="center"><br><img src="images/logo_saxo.jpg"></td>
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
