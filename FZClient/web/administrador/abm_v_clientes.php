<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];
$id_producto = $_REQUEST['id_producto'];
$id_categoria = $_REQUEST['id_categoria'];
$id_v = $_REQUEST['id_v'];
$id_grupo = $_REQUEST['id_grupo'];

if($mes == "" && $ano == "" && $id_producto == "" && $id_categoria == "" && $id_v == "") $ano = date("Y");
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

<p align="center" class="titulo">Ventas por Clientes</p>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="formu">
	<table align="center" width="200" cellspacing="2" cellpadding="2">
		<tr>
			<td width="73" class="encabezado">A&ntilde;o</td>
			<td width="111">
				<select name="ano" onChange="javascript:formu.submit();">
					<option value=""></option>
					<?
					$hoy = getdate();
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
if($oa == "") $oa = "apellido";
if($ob == "") $ob = "monto";
$orden = "ORDER BY ".$oa." ".$lado.", ".$ob." ".$lado;

if($id_producto == 0){
	$where = "";
	if($_SESSION['admin']!="ok"){
		$where="WHERE v.id_vendedor=" . $_SESSION['id_vendedor'] . "  and";
	} else{
		$where =" WHERE";
	}
	if($mes > 0){ $where = $where . " month(fecha)=" . $mes . "   and";}
	if($ano > 0){ $where = $where . " year(fecha)=" . $ano. "   and";}
	if($id_categoria > 0){ $where = $where . " c.id_categoria=" . $id_categoria. "   and";}
	if($id_v > 0){ $where = $where . " c.id_vendedor=" . $id_v. "   and";}
	if($id_grupo > 0){ $where = $where . " g.id_grupo=" . $id_grupo. "   and";}
	
	$where = substr($where,0,strlen($where)-5);
	
	$sql = "SELECT v.id_cliente, c.apellido, c.nombre, v.id_venta, 
		SUM( CASE WHEN unidades = 1 THEN vd.cant ELSE 0 END ) AS botellas, 
		SUM( CASE WHEN unidades = 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS botellasV, 
		SUM( CASE WHEN unidades = 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS botellasB, 
		SUM( CASE WHEN unidades > 1 THEN vd.cant ELSE 0 END ) AS cajas, 
		SUM( CASE WHEN unidades > 1 AND regalo != 1 THEN vd.cant ELSE 0 END ) AS cajasV, 
		SUM( CASE WHEN unidades > 1 AND regalo = 1 THEN vd.cant ELSE 0 END ) AS cajasB,
		SUM(p.ue * vd.cant) AS cant_eq,
		ROUND((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd_CONBONIFICACION,
		ROUND((SUM(CASE WHEN regalo != 1 THEN vd.precio * vd.cant ELSE 0 END) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_sd,
		ROUND((SUM(vd.precio * p.ue * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_eq_sd,
		SUM(CASE WHEN regalo != 1 THEN vd.precio_final * vd.cant ELSE 0 END) AS monto,
		ROUND(SUM(vd.precio_final * p.ue * vd.cant)) AS monto_eq
		FROM ventas v 
		INNER JOIN clientes c on v.id_cliente = c.id_cliente
		INNER JOIN ventas_detalle vd on vd.id_venta = v.id_venta
		INNER JOIN productos p ON p.id_producto = vd.id_producto
		INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
		LEFT JOIN grupos g on g.id_grupo = c.id_grupo
		$where
		GROUP BY id_cliente 
		$orden";

	//echo ($sql."<br><br>");
	$q = query($sql);
	
	$cajas = 0;
	$monto = 0;
	$botellas = 0;
	$bonif = 0;
	$monto = 0;
			
	if($where != " ") $d = "AND";
	
	if(mysql_num_rows($q)>0){
		?>	
		<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr class="t" height="30">
				<td class="t" width="4%">&nbsp;</td>
				<td class="t" width="40%"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=apellido&ob=monto&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por clientes" class="link_t">Cliente</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=botellas&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas" class="link_t">Botellas</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=botellasV&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas vendidas" class="link_t">BV</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=botellasB&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de botellas bonificadas" class="link_t">BB</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cajas&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas" class="link_t">Cajas</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cajasV&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas vendidas" class="link_t">CV</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cajasB&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad de cajas bonificadas" class="link_t">CB</a></td>
				<td class="t" width="6%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cant_eq&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad Equivalentes" class="link_t">Cant Eq.</a></td>
				<td class="t" width="10%" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=monto&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Monto" class="link_t">Monto</a></td>
				<td class="t" width="4%">&nbsp;</td>
			</tr>
		  <?
		
		while($rs=mysql_fetch_array($q)){
			$id_cliente = $rs['id_cliente'];
			$nombre = $rs['apellido'];
			$n = $rs['nombre'];
			if($n != "") $nombre = $nombre.", ".$n;
			$cajas = $rs['cajas'];
			$cajasV = $rs['cajasV'];
			$cajasB = $rs['cajasB'];
			$cajas_T += $cajas;
			$cajas_TV += $cajasV;
			$cajas_TB += $cajasB;
			$cant_eq = $rs['cant_eq'];
			$cant_eq_T += $cant_eq;
			$botellas = $rs['botellas'];
			$botellasV = $rs['botellasV'];
			$botellasB = $rs['botellasB'];
			$botellas_T += $botellas;
			$botellas_TV += $botellasV;
			$botellas_TB += $botellasB;
			$monto = $rs['monto'];
			if($monto == "") $monto = $rs['monto_sd'];
			$monto_T += $monto;
			$reg += 1;
			$c = $flag ? "c1":"c2";
			$flag = !$flag;
			?>
			<tr height="25">
				<td class="<?= $c?>">&nbsp;</td>
				<td class="<?= $c?>" style="border-right-style:solid; border-right-color:#333333;"><?= $nombre?></td>
				<td class="<?= $c?>" align="center"><?= number_format($botellas,0,',','.')?></td>
				<td class="<?= $c?>" align="center"><?= number_format($botellasV,0,',','.')?></td>
				<td class="<?= $c?>" align="center" style="border-right-style:solid; border-right-color:#333333;"><?= number_format($botellasB,0,',','.')?></td>
				<td class="<?= $c?>" align="center"><?= number_format($cajas,0,',','.')?></td>
				<td class="<?= $c?>" align="center"><?= number_format($cajasV,0,',','.')?></td>
				<td class="<?= $c?>" align="center" style="border-right-style:solid; border-right-color:#333333;"><?= number_format($cajasB,0,',','.')?></td>
				<td class="<?= $c?>" align="center"><?= number_format($cant_eq,0,',','.')?></td>
				<td class="<?= $c?>" align="right">$&nbsp;<?= number_format($monto,2,',','.')?></td>
				<td class="<?= $c?>">&nbsp;</td>
			</tr>
		<?
		}
		?>
			<tr height="30">
				<td class="t">&nbsp;</td>
				<td class="t">Total&nbsp;&nbsp;&nbsp;&nbsp;<?= $reg?>&nbsp;registros</td>
				<td align="center" class="t"><?= number_format($botellas_T, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($botellas_TV, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($botellas_TB, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($cajas_T, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($cajas_TV, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($cajas_TB, 0, ',', '.')?></td>
				<td align="center" class="t"><?= number_format($cant_eq_T,0,',','.')?></td>
				<td align="right" class="t">$&nbsp;<?=number_format($monto_T,2,',','.')?></td>
				<td class="t">&nbsp;</td>
			</tr>
		</table>
	<?
	}else{
		echo("<p class='titulo' align='center'>No se ha encontrado ningun registro</p>");
	}
}else{
	$where = "";
	if($_SESSION['admin']!="ok"){
		$where = " AND v.id_vendedor=" . $_SESSION['id_vendedor'];
	} else{
		$where = "";
	}
		if($mes > 0) $where = $where . " AND month(fecha)=" . $mes;
		if($ano > 0) $where = $where . " AND year(fecha)=" . $ano;
		if($id_categoria > 0) $where = $where . " AND cc.id_categoria=" . $id_categoria;
		if($id_v > 0) $where = $where . " AND v.id_vendedor=" . $id_v;
		if($id_grupo > 0){ $where = $where . " AND g.id_grupo=" . $id_grupo;}

	if($_REQUEST['prod'] != "") $d = " AND";
	//echo("WHERE vd.id_producto = ".$id_producto." ". $where."<br>");
	
	$q2 = query("SELECT c.id_cliente, apellido, nombre, SUM(cant) AS cant, SUM(cant * p.ue) AS cant_eq, 
			ROUND((SUM(vd.precio * vd.cant * p.ue) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto_eq,
			ROUND((SUM(vd.precio * vd.cant) * (1 - v.dto_porc/100) - v.dto_fijo)*100)/100 AS monto
			FROM ventas_detalle vd 
			INNER JOIN ventas v on vd.id_venta=v.id_venta
			INNER JOIN clientes c on c.id_cliente = v.id_cliente
			INNER JOIN categoria_clientes cc on c.id_categoria = cc.id_categoria
			INNER JOIN productos p on p.id_producto = vd.id_producto
			LEFT JOIN grupos g on g.id_grupo = c.id_grupo
			WHERE vd.id_producto = ".$id_producto." ". $where ."
			GROUP BY v.id_cliente 
			ORDER BY nombre");

	$cajas = 0;
	$cant = 0;
	$monto = 0;
	if(mysql_num_rows($q2)>0){
	?>
        <table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr class="t" height="30">
                <td class="t" width="5%">&nbsp;</td>
                <td class="t" width="55%"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=apellido&ob=monto&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por clientes" class="link_t">Cliente</a></td>
                <td class="t" width="10%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cantidad&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad" class="link_t">Cantidad</a></td>
                <td class="t" width="10%" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=cant_eq&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por cantidad equivalente" class="link_t">Cantidad Eq.</a></td>
                <td class="t" width="15%" align="right"><a href="<?= $_SERVER['PHP_SELF']?>?mes=<?= $mes?>&ano=<?= $ano?>&id_categoria=<?= $id_categoria?>&id_v=<?= $id_v?>&oa=monto&ob=apellido&op=<?= $oa?>&lado=<?= $lado?>" title="Ordenar por Monto" class="link_t">Monto Neto</a></td>
                <td class="t" width="5%">&nbsp;</td>
            </tr>
            <?
            while($rs2 = mysql_fetch_array($q2)){
                $id_cliente = $rs2['id_cliente'];
                $nombre = $rs2['apellido'];
                $n = $rs2['nombre'];
                if($n != "") $nombre = $nombre.", ".$n;
                $cantidad = $rs2['cant'];
                $cantidad_T += $cantidad;
                $cant_eq = $rs2['cant_eq'];
                $cant_eq_T += $cant_eq;
                $monto_eq = $rs2['monto_eq'];
                $monto_eq_T += $monto_eq;
                $monto = $rs2['monto'];
                $monto_T += $monto;
                $reg += 1;
                $c = $flag ? "c1":"c2";
                $flag = !$flag;
                ?>
                <tr height="25">
                    <td class="<?= $c?>">&nbsp;</td>
                    <td class="<?= $c?>"><?= $nombre?></td>
                    <td class="<?= $c?>" align="center"><?= number_format($cantidad,0,',','.')?></td>
                    <td class="<?= $c?>" align="center"><?= number_format($cant_eq,0,',','.')?></td>
                    <td class="<?= $c?>" align="right">$<?= number_format($monto,2,',','.')?></td>
                    <td class="<?= $c?>">&nbsp;</td>
                </tr>
            <?
            }
            ?>
                <tr height="30">
                    <td class="t">&nbsp;</td>
                    <td class="t">Total&nbsp;&nbsp;&nbsp;&nbsp;<?= $reg?>&nbsp;registros</td>
                    <td align="center" class="t"><?= number_format($cantidad_T, 0, ',', '.')?></td>
                    <td align="center" class="t"><?= number_format($cant_eq_T, 0, ',', '.')?></td>
                    <td align="right" class="t">$&nbsp;<?=number_format($monto_T,2,',','.')?></td>
                    <td class="t">&nbsp;</td>
                </tr>
            </table>
	<?
	}else{
		echo("<p class='titulo' align='center'>No se ha encontrado ningun registro</p>");
	}
}
?>




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
