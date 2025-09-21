<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

	$iva = 1.21; // IVA ------------------------------------------------------------

$id_cliente = $_REQUEST['id_cliente'];
$id_venta = $_REQUEST['id_venta'];
$id_deposito = $_REQUEST['id_deposito'];


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
$sql = query("SELECT * FROM clientes WHERE id_cliente= ". $id_cliente);
$rs = mysql_fetch_array($sql);

$nombre = $rs['nombre']." ".$rs['apellido'];
$direccion = $rs['direccion'];
$cuit = $rs['cuit'];
$localidad = $rs['localidad'];
$mail = $rs['mail'];
$telefono = $rs['telefono'];
$id_cliente = $rs['id_cliente'];

$qv = query("SELECT * FROM ventas WHERE id_venta = $id_venta");
$rsv = mysql_fetch_array($qv);
$factura = $rsv['factura'];

?>

<table width="800" align="center" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="30%" class="encabezado">AGENTE: <?=$_SESSION['nombre_vend']?></td>
		<td width="60%" align="right"></td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr><td colspan="4"></td></tr>
	<tr height="30"><td class="t" colspan="4" align="center">Detalle de la venta</td></tr>

		<tr height="40">
			<td class="c1">&nbsp;</td>
			<td class="c1" align="center" colspan="2">Cliente:&nbsp;&nbsp;<?= $nombre?></td>
			<td class="c1">&nbsp;</td>
		</tr>
		<tr>
			<td class="c2">&nbsp;</td>
			<td class="c2" colspan="2">
				<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr height="25">
						<td class="dataBold">Direccion:</td>
						<td class="data"><?=$direccion?></td>
						<td class="dataBold">Factura:</td>
						<td class="data">
							<? if($factura == 1){echo "Factura A";}?>
							<? if($factura == 2){echo "Factura B";}?>
							<? if($factura == 3){echo "Factura C";}?>
						</td>
					</tr>
					<tr height="25">
						<td width="12%" class="dataBold">Localidad:</td>
						<td width="38%" class="data"><?=$localidad?></td>
						<td width="12%" class="dataBold">CUIT:</td>
						<td width="38%" class="data"><?=$cuit?></td>
					</tr>
					<tr height="25">
						<td class="dataBold">Telefono:</td>
						<td class="data"><?=$telefono?></td>
						<td class="dataBold">Mail:</td>
						<td class="data"><?=$mail?></td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
				</table>  
			</td>
			<td class="c2">&nbsp;</td>
		</tr>
		<?
		
		$qv = query("SELECT *, v.observaciones as texto FROM ventas v INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor where v.id_venta=" . $_REQUEST['id_venta']);
		$rsv = mysql_fetch_array($qv);
		
		$fecha = rotarFecha($rsv['fecha']);

		$remito = $rsv['remito'];
		//$estado=$rs['estado'];
		$dto_porc = $rsv['dto_porc'];
		$dto_fijo = $rsv['dto_fijo'];
		$observaciones = $rsv['texto'];	
		$tipo_visita = $rsv['tipo_visita'];
		$id_deposito = $rsv['id_deposito'];
		
		$n_remito = $rsv['n_remito'];
		$f_remito = rotarFecha($rsv['f_remito']);
		$n_factura = $rsv['n_factura'];
		$f_factura = rotarFecha($rsv['f_factura']);

		$factura = $rsv['factura'];
		$iva = 1;
		if($factura == 1) $iva = 1.21;
		
		$sql_p="SELECT SUM(monto) as monto from pagos where id_venta=" . $_REQUEST['id_venta'];
		$q_p=query($sql_p);
		$rs_p=mysql_fetch_array($q_p);
		
		$sql_m="SELECT round(sum(cant * precio * $iva)*(1-dto_porc)-dto_fijo) as monto from ventas_detalle vd inner join ventas v on v.id_venta=vd.id_venta where v.id_venta =" . $_REQUEST['id_venta'];
		$q_m=query($sql_m);
		$rs_m=mysql_fetch_array($q_m);
		
			if($rs_p['monto'] < $rs_m['monto']){
				$estado=0;
			}else if ($rs_p['monto'] == $rs_m['monto']){
				$estado="paid";
			}else{
				$estado=1;
			}
			//echo $estado;
		?>
		<tr>
			<td class="c1">&nbsp;</td>
			<td class="c1" colspan="2">
				<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr height="25">
						<td class="dataBold">N&deg; de Pedido :</td>
						<td class="data"><?=$remito?></td>
						<td class="dataBold">Fecha:</td>
						<td class="data"><?= $fecha?></td>
					</tr>
					<tr height="25">
						<td class="dataBold">N&deg; de Remito:</td>
						<td class="data"><?=$n_remito?></td>
						<td class="dataBold">Fecha:</td>
						<td class="data"><?= $f_remito?></td>
					</tr>
					<tr height="25">
						<td class="dataBold">N&deg; de Factura:</td>
						<td class="data"><?=$n_factura?></td>
						<td class="dataBold">Fecha:</td>
						<td class="data"><?= $f_factura?></td>
					</tr>
					<tr height="25">
						<td class="dataBold">Agente</td>
						<td class="data"><?=$rsv['nombre']?></td>
						<td class="dataBold">Mail</td>
						<td class="data"><?=$rsv['mail']?></td>
					</tr>
					<tr height="25">
						<td class="dataBold">Telefono</td>
						<td class="data"><?=$rsv['telefono']?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
				</table>
			</td>
			<td class="c1">&nbsp;</td>
		</tr>
		<?
		if($id_deposito != ""){
			$q_deposito = query("SELECT * FROM depositos WHERE id_deposito = $id_deposito");
			$rs_q = mysql_fetch_array($q_deposito);
			?>
			<tr height="30">
				<td class="c2">&nbsp;</td>
				<td class="c2" colspan="2">
					<table width="85%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tr>
							<td width="12%" class="dataBold">Deposito:</td>
							<td width="88%" class="data"><?=$rs_q['deposito']?></td></tr>
					</table>
				</td>
				<td class="c2">&nbsp;</td>
			</tr>
		<? }?>
	<tr height="15"><td colspan="4" class="t"></td></tr>
</table>

	
<br>

		<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
			<?		
			$q_c = query("SELECT * FROM ventas WHERE id_venta = $id_venta");
			if(mysql_num_rows($q_c)){
				$rsc = mysql_fetch_array($q_c);
				$dto_fijo = round($rs_c['dto_fijo']*100)/100;
				$dto_porc = round($rs_c['dto_porc']*100)/100;
				?>
				<tr height="30"><td colspan="8" class="encabezado" align="center">Detalle de la Venta</td></tr>
				<tr height="10"><td colspan="8"></td></tr>
                <tr height="30">
                    <td width="5%" class="t">&nbsp;</td>
                    <td width="50%" class="t">Producto</td>
                    <td width="8%" class="t" align="center">&nbsp;</td>
                    <td width="8%" class="t" align="center">Precio</td>
                    <td width="8%" class="t" align="center">Cantidad</td>
                    <td width="8%" class="t" align="center">Importe</td>
                    <td width="8%" class="t" align="center">Regalo</td>
                    <td width="5%" class="t">&nbsp;</td>
                </tr>
					<?
					$q = query("SELECT p.id_producto, 
								 concat(pc.categoria, ' ', pl.linea, ' - ', pv.variedad, ' - ', pp.presentacion, ' (', pp.unidades, 'x', pp.volumen, ')') AS producto, 
								 precio_final, cant, regalo
								FROM ventas_detalle vd
								INNER JOIN productos p ON p.id_producto = vd.id_producto
								INNER JOIN p_categorias pc ON pc.id_categoria = p.id_categoria
								INNER JOIN p_lineas pl ON pl.id_linea = p.id_linea
								INNER JOIN p_variedades pv ON pv.id_variedad = p.id_variedad
								INNER JOIN p_presentacion pp ON pp.id_presentacion = p.id_presentacion
								WHERE id_venta = $id_venta");
					while($rs = mysql_fetch_array($q)){
						$id_producto = $rs['id_producto'];
						$cant = $rs['cant'];
						$precio = $rs['precio_final'];
						if($factura == 1) $precio = $precio / 1.21;

						if($precio == 0) $precio = "";
						
						if($dto_fijo > 0) $dto1 = $dto_fijo * $cant_prod;
						if($dto_porc > 0) $dto2 = $precio / $dto_porc * 100;
						$precio = $precio + $dto1 + $dto2;
						
						$regalo = $rs['regalo'];
						if($regalo > 0) $precio = 0;
						$sub = $cant * $precio;
						
						if($sub == "") $sub = 0;
						$c = $flag ? "c1":"c2";
						$flag = !$flag;
						?>
						<tr height="30">
							<td class="<?= $c?>">&nbsp;</td>
							<td class="<?= $c?>"><?= $rs['producto']?></td>
							<td class="<?= $c?>" align="center">&nbsp;</td>
							<td class="<?= $c?>" align="center"><?= number_format($precio, 2, ".", ",")?></td>
							<td class="<?= $c?>" align="center"><?= $cant?></td>
							<td class="<?= $c?>" align="center"><?= number_format($sub, 2, ".", ",")?></td>
							<td class="<?= $c?>" align="center"><?= $regalo > 0 ? "<img src='images/yes.jpg'>" : ""?></td>
							<td class="<?= $c?>">&nbsp;</td>
						</tr>
					<? 
						$sub_T += $sub;
						$total_cant += $cant;
						$i++;
					}
					if($factura == 1) $iva_T = round($sub_T * ($iva-1) ,2);
					$total = $sub_T + $iva_T;
					?>
				<? } // Cierro el wile de categorias?>
				<? if($factura == 1){?>
					<tr height="30">
						<td class="t">&nbsp;</td>
						<td class="t" colspan="4">Sub Totales</td>
						<td class="t">&nbsp;</td>
						<td class="t">&nbsp;</td>
						<td class="t">&nbsp;</td>
					</tr>
					<tr height="40">
						<td class="c1">&nbsp;</td>
						<td class="c1" colspan="2">&nbsp;</td>
						<td class="c1" align="center">Sub Total</td>
						<td class="c1" align="right"></td>
						<td class="c1" align="center"><?= number_format(round($sub_T,2),2,',', '.')?></td>
						<td class="c1">&nbsp;</td>
						<td class="c1">&nbsp;</td>
					</tr>
					<tr height="40">
						<td class="c2">&nbsp;</td>
						<td class="c2" colspan="2">&nbsp;</td>
						<td class="c2" align="center">Iva</td>
						<td class="c2" align="right"></td>
						<td class="c2" align="center"><?= number_format(round($iva_T,2),2,',', '.')?></td>
						<td class="c2">&nbsp;</td>
						<td class="c2">&nbsp;</td>
					</tr>
				<? }?>
                <? if($dto_fijo != "" || $dto_porc != ""){?>
                    <tr height="30">
                        <td class="t">&nbsp;</td>
                        <td class="t" colspan="4">Descuentos</td>
                        <td class="t">&nbsp;</td>
                        <td class="t">&nbsp;</td>
                        <td class="t">&nbsp;</td>
                    </tr>
	                <? if($dto_fijo != ""){?>
                        <tr height="40">
                            <td class="c1">&nbsp;</td>
                            <td class="c1" colspan="2">&nbsp;</td>
                            <td class="c1" align="center">Fijo</td>
                            <td class="c1" align="right">$</td>
                            <td class="c1" align="center"><?=$dto_fijo?></td>
                            <td class="c1">&nbsp;</td>
                            <td class="c1">&nbsp;</td>
                        </tr>
                    <? }?>
	                <? if($dto_porc != ""){?>
                        <tr height="40">
                            <td class="c2">&nbsp;</td>
                            <td class="c2" colspan="2">&nbsp;</td>
                            <td class="c2" align="center">Porcentual</td>
                            <td class="c2" align="right">%</td>
                            <td class="c2" align="center"><?=$dto_porc?></td>
                            <td class="c2">&nbsp;</td>
                            <td class="c2">&nbsp;</td>
                        </tr>
	                <? }?>
                <? }?>
				<tr height="35">
					<td class="t">&nbsp;</td>
					<td class="t" colspan="2">Total</td>
					<td class="t" align="center">&nbsp;</td>
					<td class="t" align="center"><?=number_format($total_cant, 2, ',', '.')?></td>
					<td class="t" align="center"><?=number_format(round($total,2),2,',', '.')?></td>
					<td class="t">&nbsp;</td>
					<td class="t">&nbsp;</td>
				</tr>
			<? if($observaciones != ""){?>
				<tr height="40"><td colspan="8"></td></tr>
				<tr height="30"><td class="t">&nbsp;</td><td colspan="6" class="t">Observaciones</td></tr>
				<tr height="110">
					<td class="c1">&nbsp;</td>
					<td class="c1" colspan="6" class="txt"><?= $observaciones?></td>
					<td class="c1">&nbsp;</td>
				</tr>
				<tr height="15"><td colspan="8" class="t"></td></tr>
			<? }?>
			<tr height="30"><td colspan="8"></td></tr>
            <tr><td colspan="8" align="center"><a href="listar_ventas.php"><img src="images/b_back.png" width="30" height="30" border="0" alt="Cancelar"></a></td></tr>
			<tr height="40"><td colspan="8"></td></tr>
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
