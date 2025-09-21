<?
require("conn.php");
session_start();

$seccion = $_REQUEST['seccion'];

if($_REQUEST['agregar']){
	$archivo = $HTTP_POST_FILES["archivo"]['name'];
	if (is_uploaded_file($HTTP_POST_FILES["archivo"]['tmp_name'])) {
		copy($HTTP_POST_FILES["archivo"]['tmp_name'], "../".$seccion."/".$HTTP_POST_FILES["archivo"]['name']);
		$subio = true;
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El archivo (". $archivo .") se cargo correctamente</font>";
	}
	unset($agregar);
}

?>
<html>
<head>
<title>UPLOADER - ACORDEES .::. Selected Brands</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">

<SCRIPT LANGUAGE="JavaScript">
function confirmarA(){
		return confirm("Estás seguro que queres subir este archivo?");
}

function myClose() {
    close();
}
</SCRIPT>


</head>

<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

<table width="450" height="150" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td vAlign="top" height="30">
			<? if(!$_REQUEST['agregar']){?>
				<table align="center" cellpadding="0" cellspacing="0" border="0" width="450">
					<form action="<?=$PHP_SELF?>" method="POST" name="formu" enctype="multipart/form-data" onSubmit="return confirmarA();">
						<input type="hidden" name="agregar" value="agregar">
						<tr height="50"><td class="t" colspan="4" align="center">Subir un archivo a "<?= $seccion?>"</td></tr>
						<tr height="60">
							<td width="5%" class="c2">&nbsp;</td>
							<td width="30%" class="c2"><div align="center">Archivo</div></td>
							<td width="60%" class="c2">&nbsp;<input name="archivo" type="file" id="archivo" size="44"></td>
							<td width="5%" class="c2">&nbsp;</td>
						</tr>
						<tr height="40">
							<td colspan="4" width="100%" class="t" align="center">
								<input type="image" name="imagen1" src="images/b_insert.png" alt="Agregar la foto">&nbsp;&nbsp;
								<a href="JavaScript:window.close()"><img src="images/b_back.png" border="0" title="Cerrar la ventana"></a>
							</td>
						</tr>
					</form>
				</table>
			<? }else{?>
				<form action="<?=$PHP_SELF?>" method="POST" name="formulario">
					<table align="center" cellpadding="0" cellspacing="0" border="0" width="450" height="150">
						<tr height="40"><td class="t" align="center">Subir un archivo a "<?= $seccion?>"</td></tr>
						<tr height="70"><td class="c1" align="center"><?= $msg?></td></tr>
						<tr height="40"><td width="100%" class="t" align="center"><a href="JavaScript:window.close()"><img src="images/b_back.png" border="0" title="Cerrar la ventana"></a></td></tr>
					</table>
				</form>
			<? }?>
			</td>
		</tr>
</table>

</body>
</html>
