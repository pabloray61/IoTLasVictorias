<?
require("conn.php");
require("func.php");

session_start();
//echo("ID: ".$_SESSION['id_vendedor']."<br>");
if(!is_numeric($_SESSION['id_vendedor'])){header("Location:login.php");}

// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

//$imprimir = "ok";		//	PRINT
$insertar = "ok";		//	INSERT

// ------------------------------------------------------
$id_modificar = $_REQUEST['id_modificar'];
$id_cliente = $_REQUEST['id_cliente'];
$fecha_mod = $_REQUEST['fecha_mod'];
	list($dia, $mes, $ano) = preg_split( '[/.-]', $fecha_mod);
	$fecha_mod = $ano."-".$mes."-".$dia;
	if($fecha_mod == "--") $fecha_mod = "";
$observacion = $_REQUEST['observaciones'];
// Inserto los datos en la agenda
if ($_REQUEST['Agregar'] == "Agregar"){
	if($observacion != "" && $fecha_mod != ""){
		$id_venta = 'NULL';
		$id_vendedor = $_SESSION['id_vendedor'];
		$sql_a = "INSERT INTO agenda VALUES (NULL, $id_vendedor, $id_cliente, $id_venta, '$fecha_mod', '$observacion')";
		if($imprimir == "ok") echo $sql_a . "<br>";
		if($insertar == "ok") query($sql_a);
		unset($id_modificar);
		unset($id_cliente);
		unset($fecha_mod);
		unset($observacion);
	}
	else{
		$txt = "Debe ingresar la fecha y/o el comentario";
		list($ano, $mes, $dia) = preg_split( '[/.-]', $fecha_mod);
		$fecha_mod = $dia."-".$mes."-".$ano;
		if($fecha_mod == "--") $fecha_mod = "";
	}
}
// Guardo los datos en la agenda
if ($_REQUEST['Guardar']=="Guardar Cambios"){
	if($observacion != "" && $fecha_mod != ""){
		$id_agenda = $_REQUEST['id_agenda'];
		$sql_a = "UPDATE agenda SET id_cliente = $id_cliente, fecha = '$fecha_mod', observacion = '$observacion' WHERE id_agenda = $id_agenda";
		if($imprimir == "ok") echo $sql_a . "<br>";
		if($insertar == "ok") query($sql_a);
		unset($id_modificar);
		unset($id_cliente);
		unset($fecha_mod);
		unset($observacion);
	}
	else{
		$txt = "Debe ingresar la fecha y/o el comentario";
		list($ano, $mes, $dia) = preg_split( '[/.-]', $fecha_mod);
		$fecha_mod = $dia."-".$mes."-".$ano;
		if($fecha_mod == "--") $fecha_mod = "";
	}
}
// Elimino los datos en la agenda
$id_a = $_REQUEST["delete"];
if($id_a != ""){
	$sql_b = "DELETE FROM agenda WHERE id_agenda = $id_a";
	if($imprimir == "ok") echo $sql_b . "<br>";
	if($insertar == "ok") query($sql_b);
	$id_a = "";
}
// Limpio los valores de los campos
if ($_REQUEST['Limpiar']=="Limpiar Campos"){
	unset($id_agenda);
	unset($id_cliente);
	unset($fecha_mod);
	unset($observacion);
	unset($observaciones);
}
?>

<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script language="javascript">

function agregar(){
	return confirm("Estas seguro que desea agregar este registro de la agenda?");
}
function modificar(){
	return confirm("Estas seguro que desea modificar este registro de la agenda?");
}
function eliminar(){
	return confirm("Estas seguro que desea borrar este registro de la agenda?");
}

function add_br(){ f.observaciones.value += "<br>";}

</script>
<script language="javascript" src="calendar1.js"></script>
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
<p align='center' class='titulo'>Agenda</p>
<?
if($_SESSION['admin']!="ok"){
	$vend= "WHERE  a.id_vendedor=" . $_SESSION['id_vendedor'];
}else{
	$vend="";
}

$qv = query("SELECT count(*) AS cant FROM agenda a $vend ");
$rv = mysql_fetch_array($qv);
$cant = $rv['cant'];
if($cant > 0){
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr height="30">
    <td class="t" width="7%">&nbsp;&nbsp;Fecha</td>
    <td class="t" width="5%" align="center">Ag.</td>
    <td class="t" width="14%">Cliente</td>
    <td class="t" width="67%">Mensaje</td>
    <td class="t" width="7%">&nbsp;</td>
  </tr>
<?
$time = mktime(0,0,0,date("m"), date("d") - $cont++, date("Y")); 
$dia_s = date("w", $time); 

if($dia_s == 1) $dia = "Lunes";
if($dia_s == 2) $dia = "Martes";
if($dia_s == 3) $dia = "Miercoles";
if($dia_s == 4) $dia = "Jueves";
if($dia_s == 5) $dia = "Viernes";
if($dia_s == 6) $dia = "Sabado";
if($dia_s == 0) $dia = "Domingo";

if($dia_s == 6 || $dia_s == 0) $dia_s = 5;

$suma = (5 - $dia_s);
$suma2 = ($suma + 7);

$hoy = date(d."/".m."/".Y);
list($dia_h, $mes_h, $ano_h) = preg_split( '[/.-]', $hoy);
$h = mktime(0,0,0,$mes_h, $dia_h, $ano_h);

// Sumar Dias -----------------
	function sumarDias($numdias, $date) {
		if (isset($date)) {
			$date = time();
		}
		list($hora, $min, $seg, $dia, $mes, $anno) = explode( " ", date( "H i s d m Y"));
		$d = $dia + $numdias;
		$fecha = date("d-m-Y", mktime($hora, $min, $seg, $mes, $d, $anno));
		return $fecha;
	} 

	$semana = sumarDias($suma, $hoy);
		list($dia, $mes, $ano) = preg_split( '[/.-]', $semana);
		$semana = mktime(0,0,0,$mes,$dia,$ano);
	$semana2 = sumarDias($suma2, $hoy);
		list($dia2, $mes2, $ano2) = preg_split( '[/.-]', $semana2);
		$semana2 = mktime(0,0,0,$mes2,$dia2,$ano2);
// -----------------------------

if($_SESSION['admin']!="ok"){
	$vend= "WHERE  a.id_vendedor=" . $_SESSION['id_vendedor'];
}else{
	$vend="";
}

$q = query("SELECT a.id_agenda, a.id_vendedor, id_venta, sigla, c.nombre, c.apellido, fecha, observacion FROM agenda a 
			INNER JOIN vendedores v ON v.id_vendedor = a.id_vendedor 
			INNER JOIN clientes c ON c.id_cliente = a.id_cliente 
			WHERE activo = 1
			ORDER BY fecha ASC");
while($rs = mysql_fetch_array($q)){
	$id_agenda = $rs['id_agenda'];
	$id_venta = $rs['id_venta'];

	$fecha = $rs['fecha'];
		list($ano, $mes, $dia) = preg_split( '[/.-]', $fecha);
		$fecha = $dia."-".$mes."-".$ano;
		$date = date("l", mktime(0, 0, 0, $mes, $dia, $ano));

		if($date == "Monday") $date = "Lunes";
		if($date == "Tuesday") $date = "Martes";
		if($date == "Wednesday") $date = "Miercoles";
		if($date == "Thursday") $date = "Jueves";
		if($date == "Friday") $date = "Viernes";
		if($date == "Saturday") $date = "Sabado";
		if($date == "Sunday") $date = "Domingo";

		if($mes == "01") $m = "Enero";
		if($mes == "02") $m = "Febrero";
		if($mes == "03") $m = "Marzo";
		if($mes == "04") $m = "Abril";
		if($mes == "05") $m = "Mayo";
		if($mes == "06") $m = "Junio";
		if($mes == "07") $m = "Julio";
		if($mes == "08") $m = "Agosto";
		if($mes == "09") $m = "Septiembre";
		if($mes == "10") $m = "Octubre";
		if($mes == "11") $m = "Noviembre";
		if($mes == "12") $m = "Diciembre";

	$f = mktime(0,0,0,$mes, $dia, $ano);
	$d = ereg_replace("0", "", $dia);

	if($f <= $semana2 && $f >= $h) $fecha = $date . " " . $d;
	if($f > $semana2) $fecha = $d . " de " . $m;

	$sigla = $rs['sigla'];
	$nombre = $rs['nombre']." ".$rs['apellido'];
	$mensaje = $rs['observacion'];

	if($f <= $semana){
		$css = "data";
		$height = 20;
	}
	else{
		$css = "data";
		$height = 10;
	}

	if($f < $h && $int0 != 1){
		echo("<tr><td colspan='5' class='dataBold_c'>&nbsp;</td></tr>");
		echo("<tr><td colspan='5' class='dataBold_c'>Pendientes<br>&nbsp;</td></tr>");
		$int0 = 1;
	}
	if($f >= $h && $f <= $semana && $int != 1){
		echo("<tr><td colspan='5' class='dataBold_c'>&nbsp;</td></tr>");
		echo("<tr><td colspan='5' class='dataBold_c'>Esta semana<br>&nbsp;</td></tr>");
		$int = 1;
	}
	if($f > $semana && $f <= $semana2 && $int2 != 1){
		echo("<tr><td colspan='4' class='dataBold_c'>&nbsp;</td></tr>");
		echo("<tr><td colspan='5' class='dataBold_c'>Proxima semana<br>&nbsp;</td></tr>");
		$int2 = 1;
	}
	if($f > $semana2 && $int3 != 1){
		echo("<tr><td colspan='5' class='dataBold_c'>&nbsp;</td></tr>");
		echo("<tr><td colspan='5' class='dataBold_c'>A futuro<br>&nbsp;</td></tr>");
		$int3 = 1;
	}
	$bg = $flag ? "#dbe1e1":"#c6cbcb";
	$flag = !$flag;
	?>
  <tr bgcolor="<?= $bg?>"><td colspan="5"><img src="images/spacer.gif" height="4"></td></tr>
  <tr valign="middle" height="<?= $height?>" bgcolor="<?= $bg?>">
    <td><a href="ver_ventas_imp.php?id_venta=<?= $id_venta?>" class="fecha">&nbsp;<?= substr($fecha,0,14)?></a></td>
    <td class="<?= $css?>" align="center"><?= substr($sigla,0,3)?></td>
    <td class="<?= $css?>"><?= substr($nombre,0,20)?></td>
    <td class="<?= $css?>"><?= $mensaje?></td>
    <td align="right">
		<a href="<?= $_SERVER['PHP_SELF']?>?id_modificar=<?= $id_agenda?>"><img src="images/b_edit.png" border="0"></a>&nbsp;&nbsp;
		<a href="<?= $_SERVER['PHP_SELF']?>?delete=<?= $id_agenda?>" onClick="return eliminar();"><img src="images/b_no.png" border="0"></a>&nbsp;&nbsp;
	</td>
  </tr>
  <tr bgcolor="<?= $bg?>"><td colspan="5"><img src="images/spacer.gif" height="4"></td></tr>
  <tr><td colspan="5"><img src="images/spacer.gif" height="4"></td></tr>
<? }?>
	<tr height="20"><td colspan="5" class="t"></td></tr>
</table>	
<? 
}//cierra el if de si hay algo en la agenda
else{
	echo("<br><br><br><br><p align='center' class='encabezado'>No hay datos en la agenda</p>");
}
?>
<br><br>

<form name="f" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<?
$id_modificar = $_REQUEST['id_modificar'];
if($id_modificar != ""){
	$q2 = query("SELECT c.id_cliente, fecha, observacion FROM agenda a INNER JOIN clientes c ON c.id_cliente = a.id_cliente WHERE id_agenda = $id_modificar");
	$rs2 = mysql_fetch_array($q2);
	$id_cliente = $rs2['id_cliente'];
	$fecha_mod = $rs2['fecha'];
		list($ano, $mes, $dia) = preg_split( '[/.-]', $fecha_mod);
		$fecha_mod = $dia."-".$mes."-".$ano;
	$observaciones = $rs2['observacion'];
}
?>
<table width="500" align="center" cellpadding="0" cellspacing="0" border="0">
<? if($id_modificar != ""){?>
  <tr height="30"><td class="t" align="center" colspan="4">Modificar la Agenda</td></tr>
<?
}
else{
?>
  <tr height="30"><td class="t" align="center" colspan="4">Agregar un registro en la Agenda</td></tr>
<? }?>
<? if($txt != ""){?>
  <tr height="40"><td class="error" align="center" colspan="4"><?= $txt?></td></tr>
<? }?>
	<tr height="40">
		<td class="c1" width="3%">&nbsp;</td>
		<td class="c1" width="10%">Fecha</td>
		<td class="c1" width="84%"><input name="fecha_mod" type="text" size="10" value="<?= $fecha_mod?>">&nbsp;<img src="images/cal.gif" onClick="javascript:cal1.popup();"></td>
		<td class="c1" width="3%">&nbsp;</td>
	</tr>
	<tr height="40">
		<td class="c2">&nbsp;</td>
		<td class="c2">Cliente</td>
    	<td class="c2">
		  <select name="id_cliente">
			  <option value="NULL">Seleccione un cliente</option>
			  <?
			  if($_SESSION['admin'] == "ok"){
				$sql="SELECT * FROM clientes ORDER BY apellido, nombre";
			  }else{
				$sql="SELECT * FROM clientes WHERE id_vendedor = ".$_SESSION['id_vendedor'] ." ORDER BY apellido, nombre";
			  }
			  $q3 = query($sql);
			  while($rs3 = mysql_fetch_array($q3)){
				$apellido = $rs3['apellido'];
				$nombre = $rs3['nombre'];
				if($nombre != "") $cliente = $apellido .", ". $nombre;
				if($nombre == "") $cliente = $apellido;
			  ?>
				<option value="<?=$rs3['id_cliente']?>" <?  if($id_cliente == $rs3['id_cliente']){ echo "SELECTED";} ?>><?= $cliente?></option>
			  <? }?>
		  </select>
		</td>
		<td class="c2">&nbsp;</td>
	</tr>
	<tr height="140">
		<td class="c1">&nbsp;</td>
		<td class="c1" colspan="2" class="titulo" align="center"><textarea name="observaciones" cols="74" rows="8" id="observaciones"><?=$observaciones?></textarea></td>
		<td class="c1">&nbsp;</td>
	</tr>
	<tr height="30" valign="top" bgcolor="#dbe1e1"><td colspan="4" class="dataBold_c" align="center">Agregar un &lt;br&gt; cuando se desee hacer un enter.</td></tr>
	<tr height="40">
		<td colspan="4" class="t" align="center">
			<? if($id_modificar != ""){?>
			<input type="submit" name="Guardar" value="Guardar Cambios" onClick="return modificar();">
			<input type="hidden" name="id_agenda" value="<?= $id_modificar?>">
			<?
			}
			else{
			?>
			<input type="submit" name="Agregar" value="Agregar" onClick="return agregar();">
			<? }?>
			<input type="submit" name="Limpiar" value="Limpiar Campos">
			<input type="button" name="Button2" value="&lt;br&gt;" onClick="javascript:add_br();">
		</td>
	</tr>
</table>
	<script language="javascript">
	var cal1 = new calendar1(document.forms['f'].elements['fecha_mod']);
					cal1.year_scroll = true;
					cal1.time_comp = false;
	</script>
</form>			
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
