<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($mes == "" && $ano == "") $ano = date("Y");

$id_producto = $_REQUEST['id_producto'];
$id_categoria = $_REQUEST['id_categoria'];
$id_v = $_REQUEST['id_v'];
$id_grupo = $_REQUEST['id_grupo'];
?>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="title" -->
<title>ACORDES .::. Selected Brands .::.</title>
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->

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

<p align="center" class="titulo">ACORDES - RESUMEN</p>

<br>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="formu">
	<table align="center" width="200" cellspacing="2" cellpadding="2">
		<tr>
			<td class="encabezado">Producto</td>
			<td>
				<select name="id_producto" onChange="javascript:formu.submit();">
				  <option value="0" >Todos</option>
					<? 
					$q_producto = query("SELECT id_producto, concat(pc.categoria, ' - ', pl.linea, ' - ', pv.sigla, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto
									FROM productos p
									INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
									INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
									INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
									INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
									ORDER BY pc.orden, p.orden");
						while($rs_q = mysql_fetch_array($q_producto)){
							$id_p = $rs_q['id_producto'];
							$prod = $rs_q['producto']." .::: ".$id_p;
					?>
						<option value="<?= $id_p?>" <? if($id_p == $_REQUEST['id_producto']) echo("selected")?>><?= $prod?></option>
					<? }?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="encabezado">Clientes</td>
			<td>
                <select name="id_categoria" onChange="javascript:formu.submit();">
                    <option>Todos</option>
                      <?
                      $q = query("SELECT * FROM categoria_clientes");
                      while ($rs = mysql_fetch_array($q)){
                      ?>
                        <option value="<?=$rs['id_categoria']?>" <? if ($_REQUEST['id_categoria'] == $rs['id_categoria']){echo " SELECTED";} ?>><?=$rs['categoria']?>	</option>
                      <? }?>	
                </select>
			</td>
		</tr>
		<? if($_SESSION['admin']=="ok"){?>
			<tr>
				<td class="encabezado">Vendedor</td>
				<td>
					<select name="id_v" onChange="javascript:formu.submit();">
						<option>Todos</option>
						<?
						$q = query("SELECT * FROM vendedores ORDER BY nombre");
						while($rs=mysql_fetch_array($q)){
						?>
						<option value="<?=$rs['id_vendedor']?>" <? if ($_REQUEST['id_v']==$rs['id_vendedor']){echo " SELECTED";} ?>><?=$rs['nombre']?></option>
						<? }?>
					</select>
				</td>
			</tr>
		<? }?>
        <tr>
			<td class="encabezado">Grupo</td>
			<td>
            <? $q = query("SELECT * FROM grupos ORDER BY grupo");?>
			<select name="id_grupo" onChange="javascript:formu.submit();">
				<option>Todos</option>
				  <? while ($rs = mysql_fetch_array($q)){?>
					<option value="<?=$rs['id_grupo']?>" <? if ($_REQUEST['id_grupo'] == $rs['id_grupo']){echo " SELECTED";} ?>><?=$rs['grupo']?></option>
				  <? }?>	
			</select>
			</td>
		</tr>
	</table>
</form>
<br>

<table width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr height="50">
		<td align="center" width="50%">&nbsp;</td>
		<td align="right" width="50%"><a href="imp_reporte_resumen.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir el reporte</a></td>
	</tr>
</table>
<?
$anos = array();
$i = 0;
$a = query("SELECT year(fecha) AS ano FROM ventas WHERE year(fecha) <> '' GROUP BY ano");
while($rs = mysql_fetch_array($a)){
	$anos[$i] = $rs['ano'];
	$i++;
}
$meses = array('ENE','FEB', 'MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT', 'NOV','DIC');

$datos = array();
array_push($datos,array());  // AGREGO UN ARREGLO DENTRO DE OTRO

$where = "";
if($_SESSION['admin']!="ok"){
	$where=" AND v.id_vendedor=" . $_SESSION['id_vendedor'] . "  and";
} else{
	$where ="   AND";
}
if($id_producto > 0){ $where = $where . " p.id_producto=" . $id_producto. "   and";}
if($id_categoria > 0){ $where = $where . " c.id_categoria=" . $id_categoria. "   and";}
if($id_v > 0){ $where = $where . " v.id_vendedor=" . $id_v. "   and";}
if($id_grupo > 0){ $where = $where . " g.id_grupo=" . $id_grupo. "   and";}

$where = substr($where,0,strlen($where)-5);

$a = 0;
foreach($anos as $ano){ 
	for($m = 1; $m < 13; $m++){
		$sql = "SELECT month(fecha), year(fecha),
					SUM( CASE WHEN unidades = 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS botellas, 
					SUM( CASE WHEN unidades = 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS bb, 
					SUM( CASE WHEN unidades > 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS cajas, 
					SUM( CASE WHEN unidades > 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS cb, 
					ROUND((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd,
					ROUND(SUM(CASE WHEN regalo != 1 THEN vd.precio_final * vd.cant ELSE 0 END)) AS monto
					FROM ventas v 
					INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta 
					INNER JOIN productos p ON p.id_producto = vd.id_producto 
					INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion 
					INNER JOIN clientes c on v.id_cliente = c.id_cliente
					LEFT JOIN grupos g on g.id_grupo = c.id_grupo
					WHERE year(fecha) = '$ano' AND month(fecha) = '$m' $where
					GROUP BY month(fecha)";
		//echo ($sql."<br><br>");
		$q = query($sql);
		if(mysql_num_rows($q) > 0){
			$rs = mysql_fetch_array($q);
			$botellas = $rs['botellas'];
			$bb = $rs['bb'];
			$cajas = $rs['cajas'];
			$cb = $rs['cb'];
			$monto = $rs['monto'];
			if($monto == "") $monto = $rs['monto_sd'];
		}else{
			$botellas = 0;
			$cajas = 0;
			$monto = 0;
			$bb = 0;
			$cb = 0;
		}
		$datos[$a][$m][0] = $botellas;
		$datos[$a][$m][1] = $cajas;
		$datos[$a][$m][2] = $monto;
		$datos[$a][$m][3] = $bb;
		$datos[$a][$m][4] = $cb;		
	}
	$a++;
}

?>
<!-- -------------- BOTELLAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">BOTELLAS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][0], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][0];
				$mes_T[$m] += $datos[$a][$m][0];
				$total += $datos[$a][$m][0];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- CAJAS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">CAJAS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][1], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][1];
				$mes_T[$m] += $datos[$a][$m][1];
				$total += $datos[$a][$m][1];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- MONTOS -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">MONTOS</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center">$&nbsp;<?= number_format($datos[$a][$m][2], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][2];
				$mes_T[$m] += $datos[$a][$m][2];
				$total += $datos[$a][$m][2];
				?>
			<? }?>
			<td class="t" align="center">$&nbsp;<?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center">$&nbsp;<?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center">$&nbsp;<?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- BB -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">BB</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][3], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][3];
				$mes_T[$m] += $datos[$a][$m][3];
				$total += $datos[$a][$m][3];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>
<!-- -------------- CB -------------- -->
<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="30">
		<td class="t" width="8%" align="center">CB</td>
			<? foreach($meses as $mes){ ?>
				<td class="t" width="7%" align="center"><?= $mes?></td>
			<? }?>
		<td class="t" width="8%" align="center">TOTAL</td>
	</tr>
	<?	
	$a = $m = $total = 0;
	$ano_T = array();
	$mes_T = array();
	foreach($datos as $ano){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		?>
		<tr height="30">
			<td class="t" align="center"><?= $anos[$a]?></td>
			<? 	for($m = 1; $m < 13; $m++){?>
				<td class="<?= $c?>" align="center"><?= number_format($datos[$a][$m][4], 0, ',','.')?></td>
				<? 
				$ano_T[$a] += $datos[$a][$m][4];
				$mes_T[$m] += $datos[$a][$m][4];
				$total += $datos[$a][$m][4];
				?>
			<? }?>
			<td class="t" align="center"><?= number_format($ano_T[$a], 0, ',','.')?></td>
		</tr>
		<? $a++;
	}?>
	<tr height="30">
		<td class="t" align="center">TOTAL</td>
		<? 	for($m = 1; $m < 13; $m++){?>
			<td class="t" align="center"><?= number_format($mes_T[$m], 0, ',','.')?></td>
		<? }?>
		<td class="t" align="center"><?= number_format($total, 0, ',','.')?></td>
	</tr>
</table>
<br>


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
