<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$ver = $_REQUEST['ver'];
if($ver == "") $ver = "listar";
$id_cliente = $_REQUEST['id_cliente'];

if($_REQUEST['historial']=="Historial"){
	header("Location:abm_v_clientes.php?id_cliente=" . $_REQUEST['id_cliente']);
}

	$where = $_REQUEST['where'];

$filtro_vendedor = $_REQUEST['filtro_vendedor'];
$filtro_categoria = $_REQUEST['filtro_categoria'];
$filtro_tipo = $_REQUEST['filtro_tipo'];

// INSERTAR O IMPRIMIR
	$insertar = "ok";
	//$imprimir = "ok";
// ----------------

if($_REQUEST['Agregar']=="Agregar"){
	//chequea si el cliente lo tiene otro vendedor
	$q = query("SELECT * FROM clientes WHERE apellido = '" . $_REQUEST['nombre'] . "' AND nombre ='" . $_REQUEST['nombre'] . "'");
	$rs = mysql_fetch_array($q);

		//guarda los datos del form
		$poe = $_REQUEST['poe'];
		$apellido = $_REQUEST['apellido'];
		$nombre = $_REQUEST['nombre'];
		$sexo = $_REQUEST['sexo'];
		$telefono = $_REQUEST['telefono'];
		$mail = $_REQUEST['mail'];
		$web = $_REQUEST['web'];
		$direccion = $_REQUEST['direccion'];
		$id_tipo = $_REQUEST['id_tipo'];
		$id_categoria = $_REQUEST['id_categoria'];
		$id_lista = $_REQUEST['id_lista'];
		$dni = $_REQUEST['dni'];
		if($dni == "") $dni = 'NULL';
		$cuit = $_REQUEST['c1']."-".$_REQUEST['c2']."-".$_REQUEST['c3'];
		$pass = $_REQUEST['pass'];
		$cp = $_REQUEST['cp'];
		$contacto = $_REQUEST['contacto'];
		$celular = $_REQUEST['celular'];
		$compra = round($_REQUEST['compra']);
		$factura = $_REQUEST['factura'];
		$observaciones = $_REQUEST['observaciones'];
		$localidad = $_REQUEST['localidad'];
		$fecha_alta = $_REQUEST['fecha_alta'];
		$fecha_cumple = $_REQUEST['fecha_cumple'];	
		$id_grupo = $_REQUEST['id_grupo'];
		$referente = $_REQUEST['referente'];

	if($rs['id_cliente'] > 0){
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>Ya existe un cliente con ese nombre, consulte al administrador si dicho cliente lo tiene otro vendedor.</font>";
		$id_cliente = 0;		
		$data = 1; //flag para qeu no me pise estas variables.
	}else{
		if($sexo == "") $sexo = 0;
		if($cp == "") $cp = 0;
		if($fecha == "0000-00-00") $fecha = "";
			list($dia, $mes, $ano) = split( '[/.-]', $fecha_alta);
			$fecha_alta = $ano."-".$mes."-".$dia;
			list($dia, $mes, $ano) = split( '[/.-]', $fecha_cumple);
			$fecha_cumple = $ano."-".$mes."-".$dia;		
		if($fecha_alta == "--" OR $fecha_alta == "") $fecha_alta = "NULL";	
		if($fecha_cumple == "--" OR $fecha_cumple == "") $fecha_cumple = "NULL";
		if($fecha_alta != "NULL") $fecha_alta = "'$fecha_alta'";	
		if($fecha_cumple != "NULL") $fecha_cumple = "'$fecha_cumple'";
	
		$sql = "INSERT INTO clientes (id_cliente, poe, apellido, nombre, sexo, fecha_cumple, dni, cuit, pass, telefono, celular, mail, web,
				contacto, direccion, localidad, cp, id_tipo, id_categoria, id_lista, compra, factura, id_grupo, id_vendedor, fecha_alta, 
				referente, observaciones) VALUES (NULL, $poe, '$apellido', '$nombre', $sexo, $fecha_cumple, $dni, '$cuit', '$pass', '$telefono', 
				'$celular', '$mail', '$web', '$contacto', '$direccion', '$localidad', $cp, $id_tipo, $id_categoria, $id_lista,
				". round($_REQUEST['compra']).", '$factura', $id_grupo, ".$_SESSION['id_vendedor'] .", $fecha_alta, '$referente', 
				'$observaciones')";

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El Cliente '".$_REQUEST['nombre']." ".$_REQUEST['apellido']."' se agrego correctamente</font>";
		$id_cliente = ""; //oculta el form abm
		isset($filtro_vend);
		isset($filtro_categoria);
	}
}
if ($_REQUEST['Modificar']=="Modificar"){
	if($_SESSION['admin']=="ok"){
		$vend="id_vendedor=". $_REQUEST['id_v'] . ",";
	}else{
		$vend="";
	}
	$fecha_alta = $_REQUEST['fecha_alta'];
	if($fecha_alta != ""){
		list($dia, $mes, $ano) = split( '[/.-]', $fecha_alta);
		$fecha_alta = "'".$ano."-".$mes."-".$dia."'";
	}else{
	 	$fecha_alta = 'NULL';
	 }
	$fecha_cumple = $_REQUEST['fecha_cumple'];
	if($fecha_cumple != ""){
		list($dia, $mes, $ano) = split( '[/.-]', $fecha_cumple);
		$fecha_cumple = "'".$ano."-".$mes."-".$dia."'";
	 }else{
	 	$fecha_cumple = 'NULL';
	 }
	
	$dni = $_REQUEST['dni'];
	if($dni == "") $dni = 'NULL';
	$cuit = $_REQUEST['c1']."-".$_REQUEST['c2']."-".$_REQUEST['c3'];
	if($cuit == "--") $cuit = '';
	
	
	$sql= "UPDATE clientes SET 
	poe = '". $_REQUEST['poe'] ."',
	apellido = '". $_REQUEST['apellido'] ."',
	nombre = '". $_REQUEST['nombre'] ."',
	sexo = '".$_REQUEST['sexo']."',
	" . $vend ."
	telefono = '".$_REQUEST['telefono']."',
	mail = '".$_REQUEST['mail']."',
	web = '".$_REQUEST['web']."',
	direccion = '".$_REQUEST['direccion']."',
	id_tipo = ".$_REQUEST['id_tipo'].",
	id_categoria = ".$_REQUEST['id_categoria'].",
	id_lista = ".$_REQUEST['id_lista'].",
	dni = ".$dni.",
	cuit = '".$cuit."',
	pass = '".$_REQUEST['pass']."',
	cp = '".$_REQUEST['cp']."',
	contacto = '".$_REQUEST['contacto']."',
	celular = '".$_REQUEST['celular']."',
	compra = ".round($_REQUEST['compra']).",
	factura = ".$_REQUEST['factura'].",
	observaciones = '".$_REQUEST['observaciones']."',
	localidad = '".$_REQUEST['localidad']."',
	fecha_alta = $fecha_alta,
	fecha_cumple = $fecha_cumple,
	id_grupo = ".$_REQUEST['id_grupo'].",
	referente = '".$_REQUEST['referente']."'
	WHERE id_cliente = " . $_REQUEST['id_cliente'];

		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);

	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El Cliente '".$_REQUEST['nombre']." ".$_REQUEST['apellido']."' se modifico correctamente</font>";
	$ver = "modificar";

}
if ($_REQUEST['Borrar']== 'Borrar'){

	$q = query("SELECT count(*) as cant FROM ventas WHERE id_cliente = ".$_REQUEST['id_cliente']);
	$rs = mysql_fetch_array($q);
	if($rs['cant']==0){
		$sql= "DELETE FROM clientes WHERE id_cliente= " . $_REQUEST['id_cliente'];
		if($insertar == "ok") mysql_query($sql, $conn_id);
		if($imprimir == "ok") echo("SQL: ".$sql);
		$id_cliente = ""; //oculta el form abm
		$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>El Cliente '".$_REQUEST['nombre']." ".$_REQUEST['apellido']."' se elimino correctamente</font>";
	}else{
		$msg = "<img src='images/b_no.png' border='0'>&nbsp;<font class='send_no'>El Cliente '".$_REQUEST['nombre']." ".$_REQUEST['apellido']."' no se pudo barrar debido a que esta asociado a mas de una venta.</font>";
	}
}
if ($_REQUEST['Cancelar']=='Cancelar'){
	$id_cliente = "";
}
?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<SCRIPT LANGUAGE="JavaScript" src="calendar1.js">
function confirmarA(){
		return confirm("Estás seguro que queres agregar este Cliente?");
}
function confirmarM(){
		return confirm("Estás seguro que queres modificar este Cliente?");
}
function confirmarE(){
		return confirm("Estás seguro que queres eliminar este Cliente?");
}
</SCRIPT>

<link rel="stylesheet" type="text/css" href="js/autocompletar.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-list.js"></script>

<?
	require("funciones_java.php");
?>
<!-- InstanceEndEditable -->

<link rel="stylesheet" href="includes/menu.css" type="text/css">
<script type="text/javascript" src="includes/jquery143.js"></script>
<script type='text/javascript' src='includes/menu.js'></script>

<script type="text/javascript" src="js/stmenu.js"></script>
<script type="text/javascript">
<!--
window.onerror=function(m,u,l)
{
	window.status = "Java Script Error: "+m;
	return true;
}
//-->
</script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>


<? 
	if($_SESSION['admin'] == "ok") $admin = 1;
	
	$vendedor = $_SESSION['nombre_vend'];
	$exp = explode(",", $vendedor);
	if($exp[1] == ""){
		$n = $exp[0];
	}else{
		$n = $exp[1];
	}
	
	include("_menu.php");
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="121" valign="top">
				<table width="100%" height="121" border="0" cellpadding="0" cellspacing="0" id="HEADER">
					<tr>
						<td width="343" valign="top" class="header-left3">
						  <img src="images/headers/mm-ap.jpg" width="341" height="80">
						  <p class="textToolBar">&nbsp;&nbsp;&nbsp;&nbsp;Bienvenido <?= $n?></p>
						</td>
						<td class="expand3">&nbsp;</td>
						<td width="358" valign="top" class="header-right3">
							<p>&nbsp;<br><br><br></p><p>&nbsp;</p>
					    	<p align="right"><a href="logout.php" class="textToolBarLink">Log out</a>&nbsp;&nbsp;&nbsp;</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		  <td height="15"><div align="right"></div></td>
		</tr>	
		<tr valign="top">
			<td height="5">
			  <!-- InstanceBeginEditable name="SubMenu" -->
			
			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td height="30">&nbsp;</td></tr>
		<tr>
			<td valign="top" height="30">
			  <!-- InstanceBeginEditable name="body" -->

<br>
<?
$mst = $_REQUEST['mst'];
if($mst != "") echo("<div align='center'><img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>".$_REQUEST['mst']."</font></div><br>");
if($msg != "") echo("<div align='center'>".$msg."</div><br>");
?>
<br>
<?
if($ver != "listar"){
?>
	<table width="700" align="center" cellpadding="0" cellspacing="1">
		<? if($id_cliente == ""){?>
		<tr height="30"><td class="t" colspan="4" align="center">Agregar un nuevo cliente</td></tr>
		<? }?>
		<? if($id_cliente > 0){?>
			<?   
			$qi = query("SELECT id_cliente FROM clientes c 
				LEFT JOIN categoria_clientes cc on c.id_categoria = cc.id_categoria 
				LEFT JOIN tipo_clientes t on c.id_tipo = t.id_tipo 
				LEFT JOIN listas l on c.id_lista = l.id_lista 
				$where");
			$i = 0;
			$array_clientes = array();
			while($ri = mysql_fetch_array($qi)){
				$array_clientes[$i] = $ri['id_cliente'];
				$i++;
			}
			$pos = array_search($id_cliente, $array_clientes);
			$ant = $array_clientes[$pos - 1];
			$sig = $array_clientes[$pos + 1];
			if($ant != "") $ant = "<a href='". $_SERVER['PHP_SELF'] ."?id_cliente=". $ant ."&ver=modificar&where=".$where."'><img src='images/ant.png' border='0'></a>";
			if($sig != "") $sig = "<a href='". $_SERVER['PHP_SELF'] ."?id_cliente=". $sig ."&ver=modificar&where=".$where."'><img src='images/sig.png' border='0'></a>";
			//echo($ant." < ".$id_cliente." < ".$sig."<br>");
			?>
		<tr height="30">
			<td class="t"><?= $ant?></td>
				<td class="t" colspan="2" align="center">Modificar el Cliente</td>
			<td class="t"><?= $sig?></td>
		</tr>
		<? }?>
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="form">
			<input type="hidden" name="where" value="<?= $where?>">
			<input type="hidden" name="ver" value="insert">
			<tr height="30">
				<td width="25" class="c2">&nbsp;</td>
				<td width="150" class="c2"><div align="center">Tipo de cliente</div></td>
				<td width="500" class="c2">&nbsp;
					<? 
					if($id_cliente > 0){
						$q = query("SELECT * FROM clientes WHERE id_cliente= ". $id_cliente);
						$rs = mysql_fetch_array($q);
						$poe = $rs['poe'];
					}
					if($poe == "") $poe = $_REQUEST["poe"];
					?>
					<select name="poe" onChange="vbscript:form.submit">
						<option value=""></option>
						<option value="1" <?	if ( $poe == "1") echo " SELECTED "?>>Persona</option>
						<option value="2" <?	if ( $poe == "2") echo " SELECTED "?>>Empresa</option>
					</select>
				</td>
				<td width="25" class="c2">&nbsp;</td>
			</tr>			
			<tr height="1"><td></td></tr>  
		</form>
		<form action="<?= $_SERVER['PHP_SELF']?>" method="POST" name="formu">
			<input type="hidden" name="poe" value="<?= $_REQUEST['poe']?>">
			<?	if($id_cliente > 0){
					$q = query("SELECT * FROM clientes WHERE id_cliente= ". $id_cliente);
					$rs = mysql_fetch_array($q);
					$poe = $rs['poe'];
					$apellido = $ap = $rs['apellido'];
					$nombre = $no = $rs['nombre'];
					$sexo = $rs['sexo'];
					$telefono = $rs['telefono'];
					$mail = $rs['mail'];
					$web = $rs['web'];
					$direccion = $rs['direccion'];
					$id_tipo = $rs['id_tipo'];
					$id_categoria = $rs['id_categoria'];
					$id_lista = $rs['id_lista'];
					$dni = $rs['dni'];
					$cuit = $rs['cuit'];
					list($c1, $c2, $c3) = split('[/.-]', $cuit);
					$pass = $rs['pass'];
					$cp = $rs['cp'];
					$contacto = $rs['contacto'];
					$celular = $rs['celular'];
					$observaciones = $rs['observaciones'];
					$compra = $rs['compra'];
					$factura = $rs['factura'];
					$localidad = $rs['localidad'];
					$id_grupo = $rs['id_grupo'];
					$fecha_alta = $rs['fecha_alta'];
					$referente = $rs['referente'];
					$fecha_cumple = $rs['fecha_cumple'];

						if($fecha_alta != ""){
							list($ano, $mes, $dia) = split( '[/.-]', $fecha_alta);
							$fecha_alta = $dia."-".$mes."-".$ano;
							if($fecha_alta == "--") $fecha_alta = "";
						}
						if($fecha_cumple != ""){
							list($ano, $mes, $dia) = split( '[/.-]', $fecha_cumple);
							$fecha_cumple = $dia."-".$mes."-".$ano;
							if($fecha_cumple == "--") $fecha_cumple = "";
							if($fecha_cumple == "00-00-0000") $fecha_cumple = "";
						}
					$id_vendedor = $rs['id_vendedor'];
					
			?>
			  <input type="hidden" name="id_cliente" value="<?= $id_cliente?>">
			  <input type="hidden" name="poe" value="<?= $poe?>">
			  <input type="hidden" name="where" value="<?= $where?>">
		 	<? }?>
			<?	if($poe > 0){?>
				<? if($poe == 1){ ?>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">Nombre</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="nombre" value="<?= $nombre?>" size="60"></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">Apellido</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="apellido" value="<?= $apellido?>" size="60"></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">Sexo</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;Masc<input type="radio" name="sexo" value="1" <? if($sexo == 1) echo("checked");?>>&nbsp;-&nbsp;Fem<input type="radio" name="sexo" value="2" <? if($sexo == 2) echo("checked");?>></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">Fecha de Nacimiento</div></td>
						<td width="500" class="c1">&nbsp;
							<input name="fecha_cumple" type="text" size="10" value="<?= $fecha_cumple?>">&nbsp;
							<img src="images/cal.gif" onClick="javascript:cal12.popup();"></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">DNI</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;<input name="dni" type="text" size="8" value="<?= $dni?>" maxlength="8" onKeyPress="return validaDNI(event);"></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
				<? }?>
				<? if($poe == 2){ ?>
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">Razon Social</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="apellido" value="<?= $apellido?>" size="60"></td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>			
					<tr height="30">
						<td width="25" class="c1">&nbsp;</td>
						<td width="150" class="c1"><div align="center">CUIT</div></td>
						<td width="500" class="c1">&nbsp;&nbsp;
							<input name="c1" type="text" size="2" value="<?= $c1?>" maxlength="2" onKeyPress="return validaDNI(event);">-
							<input name="c2" type="text" size="8" value="<?= $c2?>" maxlength="8" onKeyPress="return validaDNI(event);">-
							<input name="c3" type="text" size="1" value="<?= $c3?>" maxlength="1" onKeyPress="return validaDNI(event);">
						</td>
						<td width="25" class="c1">&nbsp;</td>
					</tr>
				<? }?>
				<tr height="30">
					<td width="25" class="c1">&nbsp;</td>
					<td width="150" class="c1"><div align="center">Contraseña</div></td>
					<td width="500" class="c1">&nbsp;&nbsp;<input name="pass" type="text" size="8" value="<?= $pass?>" maxlength="8" onKeyPress="return validaPass(event);"></td>
					<td width="25" class="c1">&nbsp;</td>
				</tr>
				<tr height="1"><td></td></tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Telefono</div></td>
					<td width="500" class="c2">&nbsp;&nbsp;<input name="telefono" type="text" size="25" value="<?= $telefono?>"></td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Celular</div></td>
					<td width="500" class="c2">&nbsp;&nbsp;<input name="celular" type="text" size="25" value="<?=$celular?>"></td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Mail</div></td>
					<td width="500" class="c2">&nbsp;&nbsp;<input type="text" name="mail" value="<?=$mail?>" size="60"></td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Web</div></td>
					<td width="500" class="c2">&nbsp;&nbsp;<input type="text" name="web" value="<?=$web?>" size="60"></td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="1"><td></td></tr>
				<tr height="30">
					<td width="25" class="c1">&nbsp;</td>
					<td width="150" class="c1"><div align="center">Contacto</div></td>
					<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="contacto" size="60"  value="<?=$contacto?>"></td>
					<td width="25" class="c1">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c1">&nbsp;</td>
					<td width="150" class="c1"><div align="center">Direccion</div></td>
					<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="direccion" size="60" value="<?=$direccion?>"></td>
					<td width="25" class="c1">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c1">&nbsp;</td>
					<td width="150" class="c1"><div align="center">Localidad</div></td>
					<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="localidad" size="60" value="<?=$localidad?>"></td>
					<td width="25" class="c1">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c1">&nbsp;</td>
					<td width="150" class="c1"><div align="center">CP</div></td>
					<td width="500" class="c1">&nbsp;&nbsp;<input type="text" name="cp" value="<?=$cp?>" size="4" onKeyPress="return validaNumero(event);"></td>
					<td width="25" class="c1">&nbsp;</td>
				</tr>
				<tr height="1"><td></td></tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Tipo de Cliente</div></td>
					<td width="500" class="c2">&nbsp;
						<select name="id_tipo">
							<option value="0">Seleccione el tipo de cliente</option>
							<? $q_t = query("SELECT * FROM tipo_clientes order by tipo");
								while($rs_t=mysql_fetch_array($q_t)){ ?>
							<option value="<?=$rs_t['id_tipo']?>" <? echo ($rs_t['id_tipo']==$id_tipo)?"SELECTED":""?>><?=$rs_t['tipo']?></option>
							<? }?>
						</select>
					</td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Categoria de cliente</div></td>
					<td width="500" class="c2">&nbsp;
						<select name="id_categoria">
							<option value="0">Seleccione la categoria del cliente</option>
							<? $q_t=query("SELECT * FROM categoria_clientes order by categoria");
								while($rs_t=mysql_fetch_array($q_t)){ ?>
							<option value="<?=$rs_t['id_categoria']?>" <? echo ($rs_t['id_categoria']==$id_categoria)?"SELECTED":""?>><?=$rs_t['categoria']?></option>
							<? }?>
						</select>
					</td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Lista de precios</div></td>
					<td width="500" class="c2">&nbsp;
						<select name="id_lista">
							<option value="0">Seleccione una lista</option>
							<? $q_l = query("SELECT * FROM listas order by lista");
								while($rs_l=mysql_fetch_array($q_l)){ ?>
							<option value="<?=$rs_l['id_lista']?>" <? echo ($rs_l['id_lista'] == $id_lista)?"SELECTED":""?>><?=$rs_l['lista']?></option>
							<? }?>
						</select>
					</td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Cajas por Mes</div></td>
					<td width="500" class="c2">&nbsp;&nbsp;<input type="text" name="compra" size="4" value="<?=$compra?>" onKeyPress="return validaNumero(event);"></td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Tipo de Factura</div></td>
					<td width="500" class="c2">&nbsp;
						<select name="factura">
						  <option value="0">Selecionar</option>
						  <option value="1" <? if($factura == 1){echo " SELECTED ";}?>>Factura A</option>
						  <option value="2" <? if($factura == 2){echo " SELECTED ";}?>>Factura B</option>
						  <option value="3" <? if($factura == 3){echo " SELECTED ";}?>>Factura C</option>
						</select>
					</td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<tr height="30">
					<td width="25" class="c2">&nbsp;</td>
					<td width="150" class="c2"><div align="center">Grupo</div></td>
					<td width="500" class="c2">&nbsp;
						<select name="id_grupo">
							<option value="0">Seleccione un grupo</option>
							<?	
							$q_g = query("SELECT * FROM grupos ORDER BY grupo");
							while($rs_g = mysql_fetch_array($q_g)){
								$grupo = $rs_g['grupo'];
								$id_g = $rs_g['id_grupo'];
							?>
								<option value="<?= $id_g?>" <? echo ($id_g == $id_grupo) ? "SELECTED" : ""?>><?= $grupo?></option>
							<? }?>
						</select>
					</td>
					<td width="25" class="c2">&nbsp;</td>
				</tr>
				<?
				if($_SESSION['admin']=="ok"){
				?>
					<tr height="30">
						<td width="25" class="c2">&nbsp;</td>
						<td width="150" class="c2"><div align="center">Vendedor</div></td>
						<td width="500" class="c2">&nbsp;
							<select name="id_v">
								<?
								$q_v = query("SELECT nombre, id_vendedor FROM vendedores ORDER BY nombre");
								while($rs_v = mysql_fetch_array($q_v)){
									$nombre_v = $rs_v['nombre'];
									$nombre_v = substr($nombre_v, 0, 25);
								?>
								<option value="<?=$rs_v['id_vendedor']?>" <? echo ($id_vendedor==$rs_v['id_vendedor'])?" SELECTED":""; ?> ><?= $nombre_v?></option>
								<? }?>
							</select>
						</td>
						<td width="25" class="c2">&nbsp;</td>
					</tr>
				<? }?>
					<tr height="30">
						<td width="25" class="c2">&nbsp;</td>
						<td width="150" class="c2"><div align="center">Fecha de alta</div></td>
						<td width="500" class="c2">&nbsp;
							<?	if($id_cliente == "") $fecha_alta = date(d."-".m."-".Y)	?>
							<input name="fecha_alta" type="text" size="10" value="<?= $fecha_alta?>">&nbsp;
							<img src="images/cal.gif" onClick="javascript:cal1.popup();">
							</td>
						<td width="25" class="c2">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c2">&nbsp;</td>
						<td width="150" class="c2" align="center">Referente</td>
						<td width="500" class="c2">&nbsp;&nbsp;<input size="40" type="text" id="referente" name="referente" value="<?= $referente?>" onKeyUp="ajax_showOptions(this,'apellido',event)" autocomplete="off"></td>
						<td width="25" class="c2">&nbsp;</td>
					</tr>
					<tr height="30">
						<td width="25" class="c2">&nbsp;</td>
						<td width="150" class="c2" align="center">Recomendados</td>
						<td width="500" class="c2">&nbsp;&nbsp;
							<table width="97%" cellpadding="0" cellspacing="0" align="center">
								<?
								if($no != "") $n = ", ".$no;
								$ref = $ap.$n;
								
								$qc = query("SELECT CONCAT(apellido, IF(nombre!='', ', ', ''),  IF(nombre !='', nombre, '')) AS nombre FROM clientes WHERE referente LIKE '".$ref."%'");
								if(mysql_num_rows($qc)>0){
									$i = 1;
									while($rsc = mysql_fetch_array($qc)){
										echo("<tr><td class='c2'>".$i." - ".$rsc['nombre']."</td></tr>"); 
										$i++;
									}
								}else{
									echo("<tr><td class='c2'>El cliente no tiene ninguna persona recomendada</td></tr>");
								}
								?>
								<tr height="10"><td></td></tr>
							</table>
						</td>
						<td width="25" class="c2">&nbsp;</td>
					</tr>
					<tr height="130">
						<td width="25" class="c2">&nbsp;</td>
						<td width="150" class="c2"><div align="center">Observaciones</div></td>
						<td width="500" class="c2">&nbsp;&nbsp;<textarea name="observaciones" cols="75" rows="7"><?=$observaciones?></textarea></td>
						<td width="25" class="c2">&nbsp;</td>
					</tr>
					<?
					if ($id_cliente>0){
					?>
						<tr height="50">
							<td width="25" class="t">&nbsp;</td>
							<td colspan="2" class="t" align="center">
								<input type="hidden" value="<?= $id_cliente?>" name="id_cliente">
								<input type="image" src="images/b_save.png" onClick="return confirmarM();">
								<input type="hidden" name="Modificar" value="Modificar">&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="abm_ventas_cliente.php?id_cliente=<?= $id_cliente?>"><img src="images/historial.png" border="0" alt="Historial del cliente <?= $apellido?>" width="30" height="30"></a>							
							</td>
							<td width="25" class="t">&nbsp;</td>
						</tr>
					<? }else{?> 
						<tr height="50">
							<td width="25" class="t">&nbsp;</td>
							<td colspan="2" class="t" align="center">
								<input type="image" src="images/b_insert.png" onClick="return confirmarA();">
								<input type="hidden" name="Agregar" value="Agregar">&nbsp;&nbsp;
								<a href="<?= $_SERVER['PHP_SELF']?>?Cancelar=Cancelar"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a>
							</td>
							<td width="25" class="t">&nbsp;</td>
						</tr>
					<? }?> 
			<? }// si no tiene id o poe
			else{?>
				<tr height="15">
					<td width="25" class="t">&nbsp;</td>
					<td colspan="2" class="t" align="center"></td>
					<td width="25" class="t">&nbsp;</td>
				</tr>
			<? }?> 
		</form>
	</table>
<?
}
else{ // si no es LISTAR
?>
	<table width="900" align="center" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td width="5%">&nbsp;</td>
			<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
			<td width="60%" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?ver=insert"><img src="images/b_insert_new.png" border="0" alt="Ingresar un nuevo cliente"></a></td>
			<td width="5%">&nbsp;</td>
		</tr>
		<tr><td colspan="4"></td></tr>
		<tr height="30"><td class="t" colspan="4" align="center">Clientes Cargados</td></tr>
		<tr><td colspan="4" width="100%" class="t" align="center"></td></tr>

		<form method="post" name="filtro" action="<?=$_SERVER['PHP_SELF']?>">
		
			<?	if($_SESSION['admin']=="ok"){?>
			  <tr height="40">
	  			<td class="c1">&nbsp;</td>
				<td class="c1" align="right">Filtro vendedor&nbsp;&nbsp;</td>
				<td class="c1">&nbsp;
				  <select name="filtro_vendedor" onChange="filtro.submit();">
					<option value="all">Todos</option>
					<?
					$sql_v = "SELECT * FROM vendedores WHERE id_vendedor > 1 order by nombre";
					$q_v = query($sql_v);
					while($rs_v = mysql_fetch_array($q_v)){
					?>
						<option value="<?=$rs_v['id_vendedor']?>" <? echo ($filtro_vendedor == $rs_v['id_vendedor'])? " SELECTED":""; ?>><?=$rs_v['nombre']?></option>
					<? }?>
				  </select>
				</td>
				<td class="c1">&nbsp;</td>
			  </tr>
			<? }?>
		  <tr height="40">
			<td class="c2">&nbsp;</td>
			<td class="c2" align="right">Categoria de Cliente&nbsp;&nbsp;</td>
			<td class="c2">&nbsp;
			  <select name="filtro_categoria" onChange="filtro.submit();">
				<option value="all">Todos</option>
				<?
				$i = 0;
				$sql_t="SELECT * FROM categoria_clientes";
				$q_t=query($sql_t);
				while($rs_t=mysql_fetch_array($q_t)){
				?>
				<option value="<?=$rs_t['id_categoria']?>" <? echo ($filtro_categoria==$rs_t['id_categoria'])? " SELECTED":""; ?>><?=$rs_t['categoria']?></option>
				<? }?>
			  </select>
			</td>
			<td class="c2">&nbsp;</td>
		  </tr>
		  <tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="right">Tipo de contacto&nbsp;&nbsp;</td>
			<td class="c1">&nbsp;
			<?
			$filtro_c = $_REQUEST['filtro_c'];
			?>
			  <select name="filtro_tipo" onChange="filtro.submit();">
				<option value="">Todos</option>
				<?
				$q_t = query("SELECT * FROM tipo_clientes");
				while($rs_t = mysql_fetch_array($q_t)){
				?>
					<option value="<?=$rs_t['id_tipo']?>" <? echo ($filtro_tipo==$rs_t['id_tipo'])? " SELECTED":""; ?>><?=$rs_t['tipo']?></option>
				<? }?>
			  </select>
			</td>
			<td class="c1">&nbsp;</td>
		  </tr>
		</form>	
		<tr>
			<td colspan="4">
				<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
				<?
				// ------ ORDEN --------			
				$lado = $_REQUEST['lado'];		
				$oa = $_REQUEST['oa'];
				$ob = $_REQUEST['ob'];
				$op = $_REQUEST['op'];
				if($oa != $op) $lado = "DESC";
				if($lado == "DESC"){
					$lado = "ASC";
				}else{
					$lado = "DESC";
				}
				if($oa == "" && $lado == "DESC") $lado = "ASC";
				if($oa == "") $oa = "c.apellido";
				if($ob == "") $ob = "c.nombre";
				$orden = "ORDER BY ".$oa." ".$lado.", ".$ob." ".$lado;
				
				// --------------------
				?>
				  <tr height="35">
				  	<td width="2%" class="t"></td>
					<td width="21%" class="t"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=apellido&ob=nombre&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por nombre" class="link_t">Nombre</a></td>
					<td width="16%" class="t">Telefono</td>
					<td width="5%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=mail&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar las direccion de e-mail" class="link_t">E-mail</a></td>
					<td width="5%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=web&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar las direcciones de web" class="link_t">Web</a></td>
					<td width="8%" class="t" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=id_vendedor&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar por Vendedor" class="link_t">Vend.</a></td>
					<td width="15%" class="t"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=categoria&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar por Categoria de cliente" class="link_t">Categoria</a></td>
					<td width="12%" class="t"><a href="<?= $_SERVER['PHP_SELF']?>?id_novios=<?= $id_novios?>&oa=lista&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar por Lista de Precios" class="link_t">Lista</a></td>
					<td width="16%" class="t">&nbsp;</td>
				  </tr>
				<?
				$vend = "";
				if($_SESSION['admin'] != "ok"){
					$vend= " id_vendedor=" . $_SESSION['id_vendedor'];
				}else{
					if($filtro_vendedor != "" AND $filtro_vendedor != "all"){ 
						$vend = " id_vendedor = " . $filtro_vendedor;
					}
				}			
				if($filtro_tipo != "" and $filtro_tipo != "all") $tipo = " t.id_tipo = ".$filtro_tipo;
				if($filtro_categoria != "" and $filtro_categoria != "all") $categoria = " c.id_categoria = ".$filtro_categoria;
				
				if($vend != "" || $tipo != "" || $categoria != "") $w = " WHERE";
				if($vend != "" && ($tipo != "" || $categoria != "")) $w2 = " and";
				if($tipo != "" && $categoria != "") $w3 = " and";
				
				$where = $w ." ". $vend ." ". $w2 ." ". $tipo ." ". $w3 ." ". $categoria ." ". $sq2 ." ". $orden;
				//echo $where."<br>";
				
				$sql = "SELECT * FROM clientes c 
						LEFT JOIN categoria_clientes cc on c.id_categoria = cc.id_categoria 
						LEFT JOIN tipo_clientes t on c.id_tipo = t.id_tipo 
						LEFT JOIN listas l on c.id_lista = l.id_lista 
						$where";
				//echo($sql." <br><br>");

				$q = query($sql);
				while($rs = mysql_fetch_array($q)){
					$id_cliente = $rs['id_cliente'];					
					$apellido = $rs['apellido'];
					$nombre = $rs['nombre'];
					if($nombre != "") $apellido = $apellido.", ".$nombre; 
					$telefono = $rs['telefono'];
					$mail = $rs['mail'];
					$m = "";
					if($mail != "") $m = "<a href='mailto:$mail' title='$mail'><img src='images/b_mail.png' border='0'></a>";
					$web = $rs['web'];
					$w = "";
					if($web != "") $w = "<a href='http://$web' title='$web' target='_blank'><img src='images/b_web.png' border='0'></a>";
					$id_vendedor = $rs['id_vendedor'];
					$categoria = $rs['categoria'];
					$id_lista = $rs['id_lista'];
					$lista = $rs['lista'];
					
					$qv = query("SELECT sigla FROM vendedores WHERE id_vendedor = $id_vendedor");
					$rsv = mysql_fetch_array($qv);
					$sigla = $rsv["sigla"];
					
					$c = $flag ? "c1":"c2";
					$flag =! $flag;

// Asignar el categoria de lista
//$sq = "UPDATE clientes SET id_lista = ".$id_lista." WHERE id_cliente = " . $id_cliente;
//mysql_query($sq, $conn_id);

					if($filtro_c == "" || $filtro_c == "4" || $filtro_c == "5" || $filtro_c == "6"){
						?>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						  <tr height="40">
							<td class="<?= $c?>"></td>
							<td class="<?= $c?>"><?= $apellido?></td>
							<td class="<?= $c?>"><?= $telefono?></td>
							<td class="<?= $c?>" align="center"><?= $m?>&nbsp;</td>
							<td class="<?= $c?>" align="center"><?= $w?>&nbsp;</td>
							<td class="<?= $c?>" align="center"><?= $sigla?></td>
							<td class="<?= $c?>"><?= $categoria?></td>
							<td class="<?= $c?>"><?= $lista?></td>
							<td class="<?= $c?>" align="center">
								<a href="<?=$_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=modificar&where=<?= $where?>"><img src="images/b_save.png" border="0" alt="Detalle del cliente <?= $apellido?>"></a>&nbsp;
								<a href="abm_ventas_cliente.php?id_cliente=<?= $id_cliente?>"><img src="images/historial.png" border="0" alt="Historial del cliente <?= $apellido?>" width="30" height="30"></a>&nbsp;
								<a href="abm_c_transferir.php?id_cliente=<?= $id_cliente?>"><img src="images/transferir.png" border="0" alt="Transferir las ventas del cliente <?= $apellido?> a otro cliente" width="30" height="30"></a>&nbsp;
								<a href="<?= $_SERVER['PHP_SELF']?>?Borrar=Borrar&id_cliente=<?= $rs['id_cliente']?>&apellido=<?= $rs['apellido']?>&nombre=<?=$rs['nombre']?>" onClick="javascript:return confirm('¿Estas seguro que desea eliminar al contacto <?= $apellido?>?')"><img src="images/b_borrar.png" width="30" height="30" border="0" alt="Eliminar el cliente <?= $apellido?>"></a>
							</td>
						  </tr>
						  </form>
						<?
						$i += 1;
					}
					else{
						$q2 = query("SELECT sum(precio) AS precio FROM ventas v INNER JOIN ventas_detalle vd ON v.id_venta = vd.id_venta where id_cliente = $id_cliente $sq");
						$rs2 = mysql_fetch_array($q2);
						$precio = $rs2['precio'];
						if($precio == $p){
						?>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						  <tr height="30">
							<td class="<?= $c?>"></td>
							<td class="<?= $c?>"><?= $apellido?></td>
							<td class="<?= $c?>"><?= $telefono?></td>
							<td class="<?= $c?>" align="center"><?= $m?>&nbsp;</td>
							<td class="<?= $c?>" align="center"><?= $w?>&nbsp;</td>
							<td class="<?= $c?>" align="center"><?= $sigla?></td>
							<td class="<?= $c?>"><?= $categoria?></td>
							<td class="<?= $c?>"><?= $lista?></td>
							<td class="<?= $c?>">
								<a href="<?=$_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&ver=modificar"><img src="images/b_save.png" border="0" alt="Detalle del cliente <?= $apellido?>"></a>
								<a href="<?=$_SERVER['PHP_SELF']?>?id_cliente=<?= $id_cliente?>&historial=historial"><img src="images/historial.png" border="0" alt="Historial del cliente <?= $apellido?>" width="30" height="30"></a>
							</td>
						  </tr>
						  </form>
						<?
							$i += 1;
						}
					}
				}
				?>
				  <tr height="15"><td colspan="9" class="t">&nbsp;</td></tr>
				  <tr height="20"><td colspan="9">&nbsp;</td></tr>
				  <tr height="35">
				    <td>&nbsp;</td>
					<td class="encabezado" colspan="2" align="center">Total de Clientes</td>
					<td class="encabezado" colspan="4"><?= $i?></td>
					<td class="encabezado" colspan="2" valign="middle"><a href="exportar_contactos.php?filtro_v=<?= $filtro_vendedor?>&filtro_c=<?= $filtro_categoria?>&filtro_t=<?= $filtro_tipo?>" class="textToolBarLink"><img src="images/xls.jpg" border="0">&nbsp;&nbsp;Exportar lista</a></td>
					<td class="encabezado">&nbsp;</td>					
				  </tr>
				</table>
			</td>
		</tr>
	</table>					
<?
} // CIERRO EL LISTAR
if(($id_cliente > 0 || $data != 1) && $poe != ""){
?>
	<script language="javascript">
	var cal1 = new calendar1(document.forms['formu'].elements['fecha_alta']);
					cal1.year_scroll = true;
					cal1.time_comp = false;
	</script>
<?
}
if(($id_cliente > 0 || $data != 1) && $poe != "" && $poe != "2"){
?>	
	<script language="javascript">
	var cal12 = new calendar1(document.forms['formu'].elements['fecha_cumple']);
					call2.year_scroll = true;
					call2.time_comp = false;
	</script>
<? }?>



			  <!-- InstanceEndEditable -->
			</td>
		</tr>
		<tr><td vAlign="bottom"></td>
		</tr>
		<tr><td vAlign="top" height="30"></td></tr>
		<tr>
			<td height="44" align="center" valign="bottom">
				<table class="pie" id="FOOTER" height="44" cellSpacing="0" cellPadding="0" width="100%" border="0">
					<tr>
						<td align="center">© 2009 ACORDES SA - Todos los derechos reservados</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>			


</body>
<!-- InstanceEnd --></html>
