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
$foto = "novedades"; // nombre
$pag = "pag=nov"; //3 letras
?>
<SCRIPT LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>
var win=null;
function NewWindow(mypage,myname,w,h,pos,infocus){
	if(pos == "random"){
		myleft = (screen.width)?Math.floor(Math.random()*(screen.width-w)):100;
		mytop = (screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;
	}
	if(pos == "center"){
		myleft = (screen.width)?(screen.width-w)/2:100;
		mytop = (screen.height)?(screen.height-h)/2:100;
	}
	else if((pos != 'center' && pos != "random") || pos == null){
		myleft=0;
		mytop=20;
	}
	var settings = "width=" + w + ",height=" + h + ",top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no";
	var bodyattribute = 'topmargin=0 leftmargin=0 bgcolor=#000000';
	
	win = window.open("", "", settings);
	win.document.open();
	win.document.write('<html><title>'+ myname +'</title><body '+bodyattribute+'><img src="'+ mypage +'" style="margin-bottom: 0.5em"></body></html>');
	win.document.close();
		
	win.focus();
}
// -->
</script>
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
	<tr height="30"><td></td></tr>
	<tr><td class="titulos">NOVEDADES</td></tr>
	<tr height="15"><td></td></tr>
	<tr><td class="textos">Una parte importante en la propuesta comercial ha sido el desarrollo de la gráfica de los productos. <br>La respuesta de los clientes ha sido muy positiva respecto a la misma.</td></tr>
	<tr height="30"><td></td></tr>
	<tr><td class="sub-titulos"><a title="Grafica 2005" href="javascript:NewWindow('images/grafica_2005.jpg','Grafica 2005','800','600','center')">GRAFICA 2005</a></td></tr>
	<tr height="10"><td></td></tr>	
	<tr><td class="sub-titulos"><a title="Grafica 2006" href="javascript:NewWindow('images/grafica_2006.jpg','Grafica 2006','800','600','center')">GRAFICA 2006</a></td></tr>
	<tr height="10"><td></td></tr>	
	<tr><td class="sub-titulos"><a title="Grafica 2007" href="javascript:NewWindow('images/grafica_2007.jpg','Grafica 2007','800','600','center')">GRAFICA 2007</a></td></tr>
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
