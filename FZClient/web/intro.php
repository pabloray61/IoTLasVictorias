<html>
<head>
<title>.:. Acordes SA - Selected Brands .:.</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Acordes nace en el año 2003 con el objetivo de elaborar y comercializar bebidas y productos alimenticios para su venta en el mercado local y de exportación.">
<meta name="Classification" content="Sitio realizado en php con agregados en flash">
<meta name="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">
<meta http-equiv="keywords" content="acordes, acordessa, acordes sa, bodega, vinos, wine, mendoza, sinfonia, SINFONIA, saxo, SAXO, VINEYARDS, VIÑEDOS, ARGENTINA, argentina, Argentina, mendoza">

<meta name="verify-v1" content="eGt1x1S/lV+LOo5dIZY2fAQOAc4RyyMNik7i7Q8RvbI=" />

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#000000">
<table width="800" height="600" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center">
			<?
			$intro = filemtime("intro.swf");
			$url_intro = "intro.swf?last_modified=" . date("Y-m-d-G:i:s", $intro);
			?>
			<script src="writeObject.js" language="JavaScript"></script>
			<script language="JavaScript" type="text/JavaScript">
				var strAux = '';
				strAux += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="336" height="600" align="top">';
					  strAux += '<param name="movie" value="<?=$url_intro?>">';
					  strAux += '<param name=quality value=high>';
					  strAux += '<param name="LOOP" value="false">';
					  strAux += '<param name="menu" value="false">';
					  strAux += '<param name="bgcolor" value="#000000">';
					  strAux += '<embed src="<?=$url_intro?>" quality="high" bgcolor="#000000" width="336" height="600" align="top" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">';
				strAux += '</object>';
				writeObject(strAux);
			</script>
		</td>
	</tr>
</table>

</body>
</html>
