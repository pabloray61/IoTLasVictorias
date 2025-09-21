<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

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

<?
$id_categoria = $_REQUEST['id_categoria'];
?>
<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
    <form name="formu" method="post" action="<?=$_SERVER['PHP_SELF']?>">
        <tr height="30">
            <td colspan="2" class="encabezado">Cargar Pagos</td>
            <td colspan="2" class="encabezado"><?= armarSelect("id_categoria", $id_categoria, "categoria", "", "categoria_clientes", "Seleccione el grupo", "", "formu")?></td>
            <td colspan="4" align="right"><a href="imp_pagos.php" target="_blank"><img src="images/b_print.png" border="0"> &nbsp;Imprimir Pagos</a></td>
        </tr>
    </form>
	<tr height="40">
		<td class="t" width="5%">&nbsp;</td>
		<td class="t" width="15%">Fecha</td>
		<? 	if($_SESSION['admin']=="ok"){?>
			<td class="t" width="20%">Cliente</td>
			<td class="t" width="15%" align="center">Vendedor</td>
		<? }else{?>
			<td class="t" width="35%" colspan="2">Cliente</td>
		<? }?>
		<td class="t" width="10%" align="right"><div align="right">Monto</div></td>
        <td class="t" width="10%" align="right"><div align="right">Pagado</div></td>
        <td class="t" width="10%" align="right"><div align="right">Adeuda</div></td>
		<td class="t" width="15%">&nbsp;</td>
	</tr>
	<?
	if($_SESSION['admin']!="ok"){
		$vend=" WHERE c.id_vendedor=". $_SESSION['id_vendedor'];
	}else{
		$vend=" WHERE c.id_vendedor=1";
	}
	if(!empty($id_categoria)) $vend .= " AND c.id_categoria = $id_categoria";
	$sql = "SELECT v.id_venta, v.fecha, v.factura, c.id_cliente, c.nombre, c.apellido, sigla, s.nombre AS vendedor, v.id_vendedor, dto_porc, dto_fijo, 
			if(FORMAT(SUM(p.monto),0) = (SELECT FORMAT(((sum(vd.cant * vd.precio) * (1 - (vta.dto_porc / 100))) - vta.dto_fijo),0) AS m_p FROM ventas_detalle vd 
							INNER JOIN ventas vta ON vta.id_venta = vd.id_venta
							WHERE vd.id_venta = v.id_venta), 1, 0) as pagado FROM ventas v 
			INNER JOIN clientes c on c.id_cliente = v.id_cliente 
			INNER JOIN vendedores s on s.id_vendedor = v.id_vendedor 
			LEFT JOIN pagos p on p.id_venta = v.id_venta
			$vend AND ISNULL(incobrable)
			GROUP BY id_venta
			ORDER BY fecha DESC, nombre";
	//echo($sql."<br>");
	$q = query($sql);
	
	while($rs=mysql_fetch_array($q)){
		$pagado = $rs['pagado'];
		if($pagado != 1){
			$id_venta = $rs['id_venta'];
			$dto_porc = $rs['dto_porc'];
			$dto_fijo = $rs['dto_fijo'];

			$factura = $rs['factura'];
			$iva = 1;
			//if($factura == 1) $iva = 1.21;

			$q2 = query("SELECT sum(cant * precio * $iva) AS m_p 
						FROM ventas_detalle WHERE id_venta = $id_venta AND regalo != 1");
			$rs2 = mysql_fetch_array($q2);
			$monto = (($rs2['m_p'] * (1-$dto_porc/100) - $dto_fijo)	*100)/100;
			
			$q5 =  query("SELECT sum(monto) AS monto2 FROM pagos WHERE pagos.id_venta = $id_venta");
			$rs5 = mysql_fetch_array($q5);
			$monto2 = $rs5['monto2'];
			
			if($monto > $monto2 OR $monto2 == NULL){
			
			  if($monto > 0){
			
				$n = $rs['nombre'];
				$a = $rs['apellido'];
				if($n != "") $a = $a.", ".$n;
				$monto_T += $monto;
				$monto2_T += $monto2;
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				?>  
					<tr height="40">
						<td class="<?= $c?>">&nbsp;</td>
						<td class="<?= $c?>"><?= rotarFecha($rs['fecha'])?></td>
						<? 	if($_SESSION['admin']=="ok"){?>
							<td class="<?= $c?>" width="20%"><?= $a?></td>
							<td class="<?= $c?>" width="20%" align="center"><?= $rs['vendedor']?></td>
						<? }else{?>
							<td class="<?= $c?>" width="40%" colspan="2"><?= $a?></td>
						<? }?>
						<td class="<?= $c?>" align="right">$<?= number_format($monto,2,'.',',')?></td>
            			<td class="<?= $c?>" align="right">$<?= number_format($monto2,2,'.',',')?></td>
                        <td class="<?= $c?>" align="right">$<?= number_format($monto-$monto2,2,'.',',')?></td>
						<td class="<?= $c?>" align="center">
							<a href="abm_cobranzas.php?id_cliente=<?=$rs['id_cliente']?>" target="_blank"><img src="images/b_pago.png" border="0" title="Cargar Pagos"></a>&nbsp;&nbsp;
							<a href="ventas_detalle.php?id_venta=<?=$rs['id_venta']?>&id_cliente=<?=$rs['id_cliente']?>" target="_blank"><img src="images/b_ver.png" border="0" title="Ver detalle de la venta"></a>
						</td>
					</tr>
				  <?
				}
			  }
		}
	}?>
	<tr height="30">
		<td class="t" colspan="4">&nbsp;</td>
		<td class="t" align="right">$<?= number_format($monto_T,2,'.',',')?></td>
        <td class="t" align="right">$<?= number_format($monto2_T,2,'.',',')?></td>
        <td class="t" align="right">$<?= number_format($monto_T - $monto2_T,2,'.',',')?></td>
		<td class="t">&nbsp;</td>
	</tr>
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
