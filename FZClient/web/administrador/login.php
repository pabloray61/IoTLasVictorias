<?
require("conn.php");

if($_REQUEST['submit']=="OK"){
	if ($_REQUEST['id_vendedor'] != ""){
		$q = query("SELECT * FROM vendedores where id_vendedor=" . $_REQUEST['id_vendedor']);
		$rs = mysql_fetch_array($q);	
		if ($rs['pass'] == $_REQUEST['pass']){
			session_start();
			$msg = $rs['pass'] . "  " . $_REQUEST['pass'];
			$_SESSION['id_vendedor'] = $rs['id_vendedor'];
			$_SESSION['nombre_vend'] = $rs['nombre'];
			$_SESSION['logged'] = "ok";
			$s_ID = session_id();
			
			if($rs['pass'] != ""){			
				if($rs['id_vendedor'] == 1){
					$_SESSION['admin'] = "ok";
					header("Location:abm_agenda.php?" . $s_ID);
				}else{
					$_SESSION['admin'] = "";
					header("Location:abm_agenda.php?" . $s_ID);
				}
			}else{
				header("Location:change_pass.php");
			}	
		}else{
			$msg="<br><br><p align='center' class='error'>Datos incorrectos</p>";
		}
	}else{
		$msg="<br><br><p align='center' class='error'>Debe seleccionar algun Vendedor</p>";
	}
}

?>
<html>
<head>
<title>LOGIN - ACORDEES .::. Selected Brands</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="document.formu.id_vendedor.focus()">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="121" valign="top">
				<table width="100%" height="121" border="0" cellpadding="0" cellspacing="0" id="HEADER">
					<tr>
						<td width="343" valign="top" class="header-left3">
						  <img src="images/headers/mm-ap.jpg" width="341" height="80">
						</td>
						<td class="expand3">&nbsp;</td>
						<td width="358" valign="top" class="header-right3"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td vAlign="top" height="30">
				<?
				echo($_REQUEST['formu']);
				?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="formu">
					<table align="center" width="330" cellspacing="0" cellpadding="2">
						<tr height="30"><td class="t" colspan="4" align="center">Ingreso al Sistema</td></tr>
						<tr height="20"><td class="c1" colspan="4" align="center"></td></tr>
						<tr valign="middle" height="30">
							<td width="5%" class="c1">&nbsp;</td>
							<td width="30%" class="c1">Usuario</td>
							<td width="60%" class="c1">
								<select name="id_vendedor">
									<option value="">Seleccione un vendedor</option>
									<?	
										$q = query("SELECT * FROM vendedores WHERE activo = 1 ORDER BY nombre");
										while($rs = mysql_fetch_array($q)){
											echo "<OPTION ";
											if ( $rs["id_vendedor"] == $_REQUEST['id_vendedor']) echo " SELECTED ";
											echo "value = \"". $rs["id_vendedor"] . "\">" . $rs['nombre'] . "\n";
										}?>
								</select>
							<td width="5%" class="c1">&nbsp;</td>
						<tr valign="middle" height="30">
							<td class="c1">&nbsp;</td>
							<td class="c1">Contrase&ntilde;a</td>
							<td class="c1"><input type="password" name="pass"></td>
							<td class="c1">&nbsp;</td>
						</tr>
						<tr height="20"><td class="c1" colspan="4" align="center"></td></tr>
						<tr valign="middle" height="30">
							<td class="c1" colspan="4" align="center">
							  <input type="hidden" name="submit" value="OK">
							  <input type="submit" value="Login">
							</td>
						</tr>
						<tr valign="middle"><td class="c1" colspan="4"><?=$msg?></td></tr>
						<tr height="20"><td class="c1" colspan="4" align="center"></td></tr>
						<tr height="20"><td class="t" colspan="4"></td></tr>
					</table>
				</form>
			</td>
		</tr>
		<tr height="30"><td></td></tr>
</table>
</body>
</html>
