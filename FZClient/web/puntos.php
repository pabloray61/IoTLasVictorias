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
$foto = "mantenimiento"; // nombre
$pag = "pag=pun"; //3 letras
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
<?
$ver = $_REQUEST['ver'];
?>
<table width="95%" border="0" align="center"> 
	<tr height="30"><td></td></tr>
	<tr><td class="titulos">PUNTOS DE VENTA</td></tr>
	<tr height="3" height="20"><td></td></tr>
	<tr><td class="textos">Nuestros productos pueden ser ubicados en los siguientes lugares:</td></tr>
	<tr height="20"><td></td></tr>
	<tr><td class="sub-titulos"><a href="puntos.php?ver=res">RESTAURANTES</a></td></tr>
	<?
	if($ver == "res"){
	?>
	<tr height="3"><td></td></tr>
	<tr><td class="textos">A continuación se detallan algunos de nuestrso principales clientes en este rubro:</td></tr>
	<tr height="3"><td></td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Parrilla Lo Nuestro - Patio Bullrich, Capital Federal</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Vadis, Recoleta, Capital Federal</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Los Porteños, Recoleta, Capital Federal</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Lotus – Tailandes, Capital Federal</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Pinucho, Capital Federal</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Juana M, San Isidro</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;La Cartuja, San Isidro</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Lotus Neo Thai, San Isidro</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Ceres Pub, Victoria y Olivos</td></tr>
	<?	}?>
	<tr height="10"><td></td></tr>
	<tr><td class="sub-titulos"><a href="puntos.php?ver=sup">SUPERMERCADOS</a></td></tr>
	<?
	if($ver == "sup"){
	?>
	<tr height="3"><td></td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Jumbo</td></tr>
	<tr><td class="textos_c"><img src="images/ico_1.jpg">&nbsp;&nbsp;Wallmart</td></tr>
	<? }?>
	<tr height="10"><td></td></tr>
	<tr><td class="sub-titulos"><a href="puntos.php?ver=emp">EMPRESAS</a></td></tr>
	<?
	if($ver == "emp"){
	?>
	<tr height="3"><td></td></tr>
	<tr><td class="textos">Durante el año 2007 nos hemos focalizado en la venta de regalos empresariales y propuestas personalizadas para empresas.</td></tr>
	<tr><td class="textos"></td></tr>
	<? }?>
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
