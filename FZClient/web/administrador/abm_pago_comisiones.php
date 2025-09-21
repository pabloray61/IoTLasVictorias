<?
require("conn.php");
require("func.php");

session_start();
if ( $_SESSION["logged"] != "ok" ) Header ("Location: index.php");

$id_cliente = $_REQUEST['id_cliente'];
$admin = $_SESSION['admin'] == "ok" ? 1 : 0;

// IMPRIMIR O INSERTAR LAS CONSULTAS -------------------

$insertar = "ok";		//	INSERT
//$imprimir = "ok";		//	PRINT

// ------------------------------------------------------

if($_REQUEST['pagar'] == "ok"){
	$cliente = $_REQUEST['cliente'];
	for($k = 0; $k <= $_REQUEST['hasta']; $k++){
		if(!empty($_REQUEST['pago'.$k])){
			$id = $_REQUEST['pago'.$k];
			$monto += $_REQUEST['monto'.$k];
			$sql = "UPDATE ventas SET com_pagada=1 WHERE id_venta = " . $id;
			if($insertar == "ok") mysql_query($sql, $conn_id);
			if($imprimir == "ok") echo("SQL: $sql<br>");
			$i++;
		}
	}
	$msg = "<img src='images/b_ok.png' border='0'>&nbsp;<font class='send_ok'>Se han pagado $ ".number_format($monto,0,'.',',')." a $cliente.</font>";
}
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
if(!empty($msg)) echo("<center>$msg</center><br><br>");
?>
<? if(empty($id_cliente)){?>
    <table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr height="40">
            <td class="t" width="4%">&nbsp;</td>
            <? 	if($admin>0){?>
                <td class="t" width="45%">Cliente</td>
                <td class="t" width="10%" align="center">Vendedor</td>
            <? }else{?>
                <td class="t" width="55%" colspan="2">Cliente</td>
            <? }?>
            <td class="t" width="13%" align="right"><div align="right">Total vendido</div></td>
            <td class="t" width="13%" align="right"><div align="right">Comision</div></td>
            <td class="t" width="15%">&nbsp;</td>
        </tr>
        <?
        $vend = $admin>0 ? "" : " AND v.id_vendedor=". $_SESSION['id_vendedor'];

        $sql = "SELECT v.id_venta, v.id_vendedor, v.id_cliente, CONCAT(c.apellido, ' ', c.nombre) AS cliente, v.fecha, v.estado, 
                ve.sigla AS vendedor, SUM(precio_final*cant) AS total, SUM(com_fijo+precio_final*cant*com_porc/100) AS comision 
                FROM ventas v
                INNER JOIN ventas_detalle vd ON v.id_venta = vd.id_venta
                INNER JOIN clientes c ON c.id_cliente = v.id_cliente
                INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor
                WHERE (com_fijo OR com_porc) AND ISNULL(com_pagada) $vend
                GROUP BY id_cliente ORDER BY c.apellido, c.nombre";
        //echo("SQL: ".$sql."<br>");
        $q = query($sql);
        if(mysql_num_rows($q)>0){
			while($rs=mysql_fetch_array($q)){	
				$cliente = $rs['cliente'];
				$vendedor = $rs['vendedor'];
				$pagos = $rs['total'];
				$comision = $rs['comision'];
				$pago_t += $pagos;
				$comision_T += $comision;
				$c = $flag ? "c1":"c2";
				$flag = !$flag;
				?>  
					<tr height="40">
						<td class="<?= $c?>">&nbsp;</td>
						<? 	if($admin>0){?>
							<td class="<?= $c?>"><?= $cliente?></td>
							<td class="<?= $c?>" align="center"><?= $rs['vendedor']?></td>
						<? }else{?>
							<td class="<?= $c?>" colspan="2"><?= $cliente?></td>
						<? }?>
						<td class="<?= $c?>" align="right">$<?= number_format($pagos,2,'.',',')?></td>
						<td class="<?= $c?>" align="right">$<?= number_format($comision,2,'.',',')?></td>
						<td class="<?= $c?>" align="center"><a href="<?= $_SERVER['PHP_SELF']?>?id_cliente=<?=$rs['id_cliente']?>"><img src="images/b_pago.png" border="0" title="Pagar la comision"></a></td>
					</tr>
			<? }?>
        <? }else{?>
                <tr height="40"><td class="c1" colspan="6" align="center">No hay ninguna comision para pagar.</td></tr>
		<? }?>
        <tr height="30">
            <td class="t" colspan="3">&nbsp;</td>
            <td class="t" align="right">$<?= number_format($pagos_T,2,'.',',')?></td>
            <td class="t" align="right">$<?= number_format($comision_T,2,'.',',')?></td>
            <td class="t">&nbsp;</td>
        </tr>
    </table>
<? }else{?>
	<form name="formu" action="<?= $_SERVER['PHP_SELF']?>">
    	<input type="hidden" name="pagar" value="ok">
        <table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr height="40">
                <td class="t" width="15%" align="center">Fecha</td>
                <? 	if($admin>0){?>
                    <td class="t" width="35%">Cliente</td>
                    <td class="t" width="10%" align="center">Vendedor</td>
                <? }else{?>
                    <td class="t" width="45%" colspan="2">Cliente</td>
                <? }?>
                <td class="t" width="10%" align="right"><div align="right">Total vendido</div></td>
                <td class="t" width="10%" align="right"><div align="right">Comision</div></td>
                <td class="t" width="20%">&nbsp;</td>
            </tr>
            <?
            $vend = $admin>0 ? "" : " AND v.id_vendedor=". $_SESSION['id_vendedor'];
            
            $sql = "SELECT v.id_venta, v.id_vendedor, v.id_cliente, CONCAT(c.apellido, ' ', c.nombre) AS cliente, v.fecha, v.estado, 
                ve.sigla AS vendedor, SUM(precio_final*cant) AS total, SUM(com_fijo+precio_final*cant*com_porc/100) AS comision 
                FROM ventas v
                INNER JOIN ventas_detalle vd ON v.id_venta = vd.id_venta
                INNER JOIN clientes c ON c.id_cliente = v.id_cliente
                INNER JOIN vendedores ve ON ve.id_vendedor = v.id_vendedor
                WHERE (com_fijo OR com_porc) AND ISNULL(com_pagada) AND v.id_cliente = $id_cliente $vend
                GROUP BY v.id_venta ORDER BY fecha ASC";
            //echo($sql."<br>");
            $q = query($sql);
            $i = 0;
            while($rs=mysql_fetch_array($q)){
                $id_venta = $rs['id_venta'];
                $fecha = $rs['fecha'];
                $cliente = $rs['cliente'];
                $vendedor = $rs['vendedor'];
                $pagos = $rs['total'];
                $comision = $rs['comision'];
                $pagos_t += $pagos;
                $comision_T += $comision;
                $c = $flag ? "c1":"c2";
                $flag = !$flag;
				$i++;
                ?>  
                <tr height="40">
                    <td class="<?= $c?>" align="center"><?= rotarFecha($fecha)?></td>
                    <? 	if($admin>0){?>
                        <td class="<?= $c?>" width="20%"><?= $cliente?></td>
                        <td class="<?= $c?>" width="20%" align="center"><?= $vendedor?></td>
                    <? }else{?>
                        <td class="<?= $c?>" width="40%" colspan="2"><?= $cliente?></td>
                    <? }?>
                    <td class="<?= $c?>" align="right">$<?= number_format($pagos,2,'.',',')?></td>
                    <td class="<?= $c?>" align="right">$<?= number_format($comision,2,'.',',')?></td>
                    <td class="<?= $c?>" align="center"><input name="pago<?= $i?>" value="<?= $id_venta?>" type="checkbox"></td>
                </tr>
                <input type="hidden" name="monto<?= $i?>" value="<?= $comision?>">
            <? }?>
            <tr height="50">
                <td class="t" colspan="3" align="left" style="padding: 0 0 0 40px"><a href="<?= $_SERVER['PHP_SELF']?>"><img src="images/b_back.png" border="0" width="25"></a></td>
                <td class="t" align="right">$<?= number_format($pagos_t,2,'.',',')?></td>
                <td class="t" align="right">$<?= number_format($comision_T,2,'.',',')?></td>
                <td class="t" align="center"><input type="image" src="images/b_pago.png" border="0" title="Pagar la comision"></td>
            </tr>
        </table>
        <input type="hidden" name="hasta" value="<?= $i?>">
        <input type="hidden" name="cliente" value="<?= $cliente?>">
    </form>
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
