<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

if($mes == "" && $ano == "") $ano = date("Y");
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

<p align="center" class="titulo">Ventas por productos</p>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="formu">
	<table align="center" width="200" cellspacing="2" cellpadding="2">
		<tr>
			<td width="73" class="encabezado">A&ntilde;o</td>
			<td width="111">
				<select name="ano" onChange="javascript:formu.submit();">			
					<option value=""></option>
					<?
					$hoy=getdate();
					for($a = 2000; $a <= $hoy['year']+1; $a++){
					?>
					<option <? if($ano==$a) {echo " SELECTED";} ?> value="<?=$a?>"><?=$a;?></option>
					<? }?>
					</select>
			</td>
		</tr>
		<tr>
			<td class="encabezado">Mes</td>
			<td>
				<select name="mes" onChange="javascript:formu.submit();">
					<option value="0">Todos</option>
					<option <? if($mes=="1") {echo " SELECTED";} ?> value="1">Enero</option>
					<option <? if($mes=="2") {echo " SELECTED";} ?> value="2">Febrero</option>
					<option <? if($mes=="3") {echo " SELECTED";} ?> value="3">Marzo</option>
					<option <? if($mes=="4") {echo " SELECTED";} ?> value="4">Abril</option>
					<option <? if($mes=="5") {echo " SELECTED";} ?> value="5">Mayo</option>
					<option <? if($mes=="6") {echo " SELECTED";} ?> value="6">Junio</option>
					<option <? if($mes=="7") {echo " SELECTED";} ?> value="7">Julio</option>
					<option <? if($mes=="8") {echo " SELECTED";} ?> value="8">Agosto</option>
					<option <? if($mes=="9") {echo " SELECTED";} ?> value="9">Septiembre</option>
					<option <? if($mes=="10") {echo " SELECTED";} ?> value="10">Octubre</option>
					<option <? if($mes=="11") {echo " SELECTED";} ?> value="11">Noviembre</option>
					<option <? if($mes=="12") {echo " SELECTED";} ?> value="12">Diciembre</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<br>
<?
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
	if($oa == "") $oa = "p.orden";
	if($ob == "") $ob = "categoria";
	$orden = "ORDER BY ".$oa." ".$lado.", ".$ob." ".$lado;
?>	
<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr class="t" height="50">
		<td class="t" width="2%">&nbsp;</td>
		<td class="t" width="47%"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=categoria&ob=linea&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Categoria" class="link_t">Producto</a></td>
		<td class="t" width="7%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cant&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Cantidad" class="link_t">Cant</a></td>
		<td class="t" width="7%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cantV&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Cantidad Vendida" class="link_t">Vend.</a></td>
		<td class="t" width="7%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cantB&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Cantidad Bonificada" class="link_t">Bonif.</a></td>
		<td class="t" width="7%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=ue&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Agrupar por Unidades Equivalentes" class="link_t">UE</a></td>
		<td class="t" width="7%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=cant_eq&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Cantidad Equivalente" class="link_t">Cant Eq</a></td>
		<td class="t" width="12%" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&oa=precio&ob=categoria&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Montos" class="link_t">Monto</a></td>
		<td class="t" width="4%">&nbsp;</td>
	</tr>
	<?
	
	$where="";
	
	if($_SESSION['admin']!="ok"){
		$where="WHERE id_vendedor=" . $_SESSION['id_vendedor'] . "  and";
	} else{
		$where =" WHERE";
	}
	
	if($mes>0){ $where=$where . " month(fecha)=" . $mes . "   and";}
	if($ano>0){ $where= $where . " year(fecha)=" . $ano. "   and";}
	$where=substr($where,0,strlen($where)-5);

	$sql = "SELECT vd.id_producto, pc.categoria, pl.linea, pv.sigla, pp.presentacion, pp.unidades, p.ue, pp.volumen, 
			SUM(cant*ue) as cant_eq, 
			SUM(cant) as cant, 
			SUM(CASE WHEN regalo != 1 THEN cant ELSE 0 END) as cantV,
			SUM(CASE WHEN regalo = 1 THEN cant ELSE 0 END) as cantB,
			SUM(precio*cant*ue) as pprom_sd, 
			SUM(precio*cant) as precio_sd,
			SUM(precio_final*cant*ue) as pprom, 
			SUM(precio_final*cant) as precio 
			FROM ventas v 
			INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta
			INNER JOIN productos p ON p.id_producto = vd.id_producto
			INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
			INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
			INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
			INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
			$where
			GROUP BY vd.id_producto
			$orden";

	$qp_t = 0;
	//echo($sql."<br><br>");
	$q = query($sql);
	while($rs=mysql_fetch_array($q)){
		$c = $flag ? "c1":"c2";
		$flag = !$flag;
		$categoria = $rs['categoria'];
		$linea = $rs['linea'];
		$variedad = $rs['variedad']." (".$rs['sigla'].")";
		$v = "";
		if($rs['volumen'] != "") $v = " x ". $rs['volumen']." ml.";
		$presentacion = $rs['presentacion']." (".$rs['unidades']."".$v.")";
		if($variedad == " - Todas") $variedad = "";
		$producto = $categoria." - ".$linea."".$variedad." - ". $presentacion;
		
		$cant = $rs['cant'];
		$cantV = $rs['cantV'];
		$cantB = $rs['cantB'];
		$cant_T += $cant;
		$cant_TV += $cantV;
		$cant_TB += $cantB;
		$cant_eq = $rs['cant_eq'];
		$cant_eq_T += $cant_eq;
		$ue = $rs['ue'];
		if($ue == "") $ue = 0;
		$precio = $rs['precio'];
		if($precio == "") $precio = $rs['precio_sd'];
		$precio_T += $precio;
		$qp_T++;
		?>
		<tr height="30">
			<td class="<?= $c?>">&nbsp;</td>
			<td class="<?= $c?>"><?=$producto?></td>
			<td class="<?= $c?>" align="center"><?= number_format($cant, 0, ',', '.');?></td>
			<td class="<?= $c?>" align="center"><?= number_format($cantV, 0, ',', '.');?></td>
			<td class="<?= $c?>" align="center"><?= number_format($cantB, 0, ',', '.');?></td>
			<td class="<?= $c?>" align="center"><?= $ue?></td>
			<td class="<?= $c?>" align="center"><?= number_format($cant_eq, 0, ',', '.');?></td>
			<td class="<?= $c?>" align="right">$&nbsp;<?= number_format($precio, 2, ',', '.');?></td>
			<td class="<?= $c?>">&nbsp;</td>
		</tr>
	<? }?>
	<tr height="50">
		<td class="t"></td>
		<td class="t"><?= number_format($qp_T, 0, ',', '.');?> productos vendidos.</td>
		<td class="t" align="center"><?= number_format($cant_T, 0, ',', '.');?></td>
		<td class="t" align="center"><?= number_format($cant_TV, 0, ',', '.');?></td>
		<td class="t" align="center"><?= number_format($cant_TB, 0, ',', '.');?></td>
		<td class="t"></td>
		<td class="t" align="center"><?= number_format($cant_eq_T, 0, ',', '.');?></td>
		<td class="t" align="right">$&nbsp;<?= number_format($precio_T, 2, ',', '.');?></td>
		<td class="t"></td>
	</tr>
	<tr height="25"><td colspan="8" align="right" class="data">El total de las ventas por producto no incluye los descuentos.</td><td>&nbsp;</td></tr>
</table>



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
